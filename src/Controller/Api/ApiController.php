<?php

namespace App\Controller\Api;

use App\Entity\Activity;
use App\Entity\Bookings;
use App\Entity\User;
use App\Formatter\ActivityToJsonFormatter;
use App\Repository\ActivityRepository;
use App\Repository\BookingsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Formatter\BookingToJsonFormatter;

class ApiController extends AbstractController
{
    /** @var BookingToJsonFormatter */
    private $bookingToJsonFormatter;

    public function __construct(bookingToJsonFormatter $bookingToJsonFormatter)
    {
        $this->bookingToJsonFormatter = $bookingToJsonFormatter;
    }
    /**
     * @Route("/api/activitiesToJson", name="activities_to_json")
     */
    public function activitiesJson(ActivityRepository $activityRepository, Request $request): JsonResponse
    {
        $categories = $request->request->get('selectedCategories');
        $isOutdoor = $request->request->get('outdoor');
        $isIndoor = $request->request->get('indoor');
        $isAnimalsFriendly = $request->request->get('animals');;
        $isHandicapedFriendly = $request->request->get('handicaped');;

        $activities = $activityRepository->findFilteredActivities($isOutdoor,$isIndoor,$isAnimalsFriendly,$isHandicapedFriendly,$categories);

        $activitiesJson = $this->activityToJsonFormatter->format($activities);
        return new JsonResponse($activitiesJson);
    }
    /**
     * @Route("/api/bookingCreation/{id}", name="booking_creation")
     */
    public function bookingCreation(Activity $activity, Request $request, BookingsRepository $bookingsRepository, EntityManagerInterface $manager)
    {
        $newBookingStartAt = $request->request->get('newBookingStartAt');
        $newBookingEndAt = $request->request->get('newBookingEndAt');
        $booking = new Bookings();
        $booking->setActivity($activity)
            ->setStartedAt(new \DateTime($newBookingStartAt) )
            ->setEndAt(new \DateTime($newBookingEndAt))
        ;
        $manager->persist($booking);
        $manager->flush();
        $test = $booking->getId();
        $response = new Response(
            $test,
            Response::HTTP_OK,
            ['content-type' => 'text/html']
        );
        return $response->send();
    }
    /**
     * @Route("/api/bookingReservation/{id}", name="booking_reservation")
     */
    public function bookingReservation(Bookings $bookings, Request $request,BookingsRepository $bookingsRepository, EntityManagerInterface $manager)
    {
        $bookings->setBookedBy($this->getUser());
        $manager->persist($bookings);
        $manager->flush();
        $test = $bookings->getId();
        $response = new Response(
            $test,
            Response::HTTP_OK,
            ['content-type' => 'text/html']
        );
        return $response->send();
    }
    /**
     * @Route("/api/bookingCancellation/{id}", name="booking_cancellation")
     */
    public function bookingCancellation(Bookings $bookings, BookingsRepository $bookingsRepository, EntityManagerInterface $manager)
    {
        $bookings->setBookedBy(null);
        $manager->persist($bookings);
        $manager->flush();
        $test = $bookings->getId();
        $response = new Response(
            $test,
            Response::HTTP_OK,
            ['content-type' => 'text/html']
        );
        return $response->send();
    }
    /**
     * @Route("/api/bookingDelete/{id}", name="booking_delete")
     */
    public function bookingDelete(Bookings $bookings, BookingsRepository $bookingsRepository, EntityManagerInterface $manager)
    {
        $bookings->setDeletedAt(new \DateTime());
        $manager->persist($bookings);
        $manager->flush();
        $test = $bookings->getId();
        $response = new Response(
            $test,
            Response::HTTP_OK,
            ['content-type' => 'text/html']
        );
        return $response->send();
    }
    /**
     * @Route("/api/calendar/read/{id}", name="bookings_calendar_read", methods={"GET"})
     */
    public function readBookingsForCalendar(BookingsRepository $bookingsRepository, Activity $activity): JsonResponse
    {
        $bookings = $bookingsRepository->findAllBookingsByActivity($activity->getId());
        $bookingsJson = $this->bookingToJsonFormatter->format($bookings);
        return new JsonResponse($bookingsJson);
    }

}
