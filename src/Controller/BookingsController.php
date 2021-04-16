<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\Bookings;
use App\Form\BookingsType;
use App\Repository\ActivityRepository;
use App\Repository\BookingsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Formatter\BookingToJsonFormatter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

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
     * @Route("/{id}", name="bookings_index", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function index(Activity $activity): Response
    {

        if ($activity->getDeletedAt() == null) {
            return $this->render('bookings/index.html.twig', [
                'activity' => $activity,
            ]);
        }
        return $this->redirectToRoute('home');
    }

    /**
     * isGranted("ROLE_EDITOR")
     * @Route("/{id}/edit", name="bookings_edit", methods={"GET","POST"})
     */
    public function edit(Bookings $booking, Request $request): Response
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
     * @isGranted("ROLE_USER")
     * @Route("/myBookings", name="read_my_bookings", methods={"GET"})
     */
    public function readMyBookings()
    {
        return $this->render('bookings/my_bookings_show.html.twig');
    }

}
