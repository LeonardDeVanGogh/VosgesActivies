<?php

namespace App\Controller\Api;

use App\Entity\Bookings;
use App\Formatter\ActivityToJsonFormatter;
use App\Repository\ActivityRepository;
use App\Repository\BookingsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /** @var ActivityToJsonFormatter */
    private $activityToJsonFormatter;

    public function __construct(ActivityToJsonFormatter $activityToJsonFormatter)
    {
        $this->activityToJsonFormatter = $activityToJsonFormatter;
    }
    /**
     * @Route("/api/activitiesToJson", name="activities_to_json")
     */
    public function activitiesJson(ActivityRepository $activityRepository, Request $request): JsonResponse
    {
        $categories = $request->request->get('selectedCategories');


        $isOutdoor = $request->request->get('outdoor');
        $isIndoor = $_POST['indoor'];
        $isAnimalsFriendly = $_POST['animals'];
        $isHandicapedFriendly = $_POST['handicaped'];

        $activities = $activityRepository->findFilteredActivities($isOutdoor,$isIndoor,$isAnimalsFriendly,$isHandicapedFriendly,$categories);

        $activitiesJson = $this->activityToJsonFormatter->format($activities);
        return new JsonResponse($activitiesJson);
    }
    /**
     * @Route("/api/bookingReservation/{id}", name="booking_reservation")
     */
    public function bookingReservation(Bookings $bookings, Request $request,BookingsRepository $bookingsRepository, EntityManagerInterface $manager)
    {
        $bookingId = $request->get('bookingId');
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
}
