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
               /*
                for (i=0;i<"all my $_POST".length;i++){
                    if (category->getName() === $_POST[i]){
                        $activitiesJson[] = [
                            ici mon Json
                        ]
                   }
               }
               */

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
            return $activitiesJson;
    }
}