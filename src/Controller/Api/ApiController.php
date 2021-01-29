<?php

namespace App\Controller\Api;

use App\Formatter\ActivityToJsonFormatter;
use App\Repository\ActivityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function activitiesJson(ActivityRepository $activityRepository): JsonResponse
    {
        $isOutdoor = $_POST['outdoor'];
        $isIndoor = $_POST['indoor'];
        $isAnimalsFriendly = $_POST['animals'];
        $isHandicapedFriendly = $_POST['handicaped'];
        $activities = $activityRepository->findFilteredActivities($isOutdoor,$isIndoor,$isAnimalsFriendly,$isHandicapedFriendly);

        $activitiesJson = $this->activityToJsonFormatter->format($activities);
        return new JsonResponse($activitiesJson);
    }
}
