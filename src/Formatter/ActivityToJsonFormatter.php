<?php


namespace App\Formatter;


class ActivityToJsonFormatter
{
    public function format(array $activities)
    {
        $activitiesJson = [];
        foreach($activities as $activity){

            $activityCategories =  [];
            foreach($activity->getCategory() as $category){
               $activityCategories[] =  [
                   'name' => $category->getName(),
               ];
            }

            $activitiesJson[] = [
                    'id' => $activity->getId(),
                    'name' => $activity->getName(),
                    'longitude' => $activity->getLongitude(),
                    'latitude' => $activity->getLatitude(),
                    'isIndoor' => $activity->getIsIndoor(),
                    'isOutdoor' => $activity->getIsOutdoor(),
                    'isHandicaped' => $activity->getIsHandicaped(),
                    'isAnimalsFriendly' => $activity->getAnimals(),
                    'categories' => $activityCategories,
                ];
        }
            return json_encode($activitiesJson, JSON_UNESCAPED_UNICODE);
    }
}