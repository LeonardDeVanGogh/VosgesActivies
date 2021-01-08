<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\Bookings;
use App\Form\BookingsType;
use App\Formatter\ActivityToJsonFormatter;
use App\Repository\BookingsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Formatter\BookingToJsonFormatter;

/**
 * @Route("/bookings")
 */
class BookingsController extends AbstractController
{
    /** @var BookingToJsonFormatter */
    private $bookingToJsonFormatter;

    public function __construct(bookingToJsonFormatter $bookingToJsonFormatter)
    {
        $this->bookingToJsonFormatter = $bookingToJsonFormatter;
    }

    /**
     * @Route("/{id}", name="bookings_index", methods={"GET"})
     */
    public function index(BookingsRepository $bookingsRepository, Activity $activity): Response
    {
        $bookings = $bookingsRepository->findAllBookingsByActivity($activity->getId());
        if($activity->getDeletedAt() == null){
            return $this->render('bookings/index.html.twig', [
                'bookings' => $bookings,
                'activity' => $activity,
            ]);
        }else{
            return $this->redirectToRoute('home');
        }
    }
    /**
     * @Route("/calendar/read/{id}", name="bookings_calendar_read", methods={"GET"})
     */
    public function readBookingsForCalendar(BookingsRepository $bookingsRepository, Activity $activity)
    {
        $bookings = $bookingsRepository->findAllBookingsByActivity($activity->getId());
        $bookingsJson = $this->bookingToJsonFormatter->format($bookings);
        $response = new Response($bookingsJson, 200, ["Content-Type" => "application/json"]);

        return $response;
    }

    /**
     * @Route("/new", name="bookings_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {

        $booking = new Bookings();
        $form = $this->createForm(BookingsType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($booking);
            $entityManager->flush();

            return $this->redirectToRoute('bookings_index');
        }

        return $this->render('bookings/new.html.twig', [
            'booking' => $booking,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="bookings_show", methods={"GET"})
     */
    public function show(Bookings $booking): Response
    {
        return $this->render('bookings/show.html.twig', [
            'booking' => $booking,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="bookings_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Bookings $booking, Activity $activity): Response
    {
        $form = $this->createForm(BookingsType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('bookings_index', ['id' => $booking->getActivity()->getId()]);
        }

        return $this->render('bookings/edit.html.twig', [
            'booking' => $booking,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="bookings_delete", methods={"DELETE"})
     */
    public function delete(Activity $activity, Bookings $booking, Request $request, EntityManagerInterface $manager)
    {
        $booking->setDeletedAt(new \DateTime());
        $manager->persist($booking);
        $manager->flush();
        return $this->redirectToRoute('bookings_index', ['id' => $booking->getActivity()->getId()]);
    }
}
