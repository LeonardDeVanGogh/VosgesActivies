<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Activity;
use App\Entity\Category;
use App\Entity\Comment;


class ActiviteFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = \Faker\Factory::create('fr_FR');

        //Créer 3 catégories

        for ($i=1;$i<=3;$i++){
            $category = new Category();
            $category->setName($faker->sentence())
                     ->setDescription($faker->paragraph());
            $manager->persist($category);

        //Créer entre 4 6 et activités
            for($j=1;$j<=mt_rand(4,6);$j++){
            $activite = new Activity();

            $content = '<p>' . join($faker->paragraphs(5), '</p><p>') . '</p>';
            $activite->setName($faker->sentence())
                     ->setDescription($content)
                     ->setAddress("Quai du Lac, 88400 Gérardmer")
                     ->setOwner(1)
                     ->setLatitude(48.070759)
                     ->setLongitude(6.866638)
                     ->setIndoor(0)
                     ->setOutdoor(1)
                     ->setPicture($faker->imageUrl())
                     ->setCreatedAt($faker->dateTimeBetween('-6 months'));
            $manager->persist($activite);


            
            for($l=1;$l<=mt_rand(4,10);$l++){
                $content = '<p>' . join($faker->paragraphs(2), '</p><p>') . '</p>';
                $now = new \DateTime();
                $interval = $now->diff($activite->getCreatedAt());
                $days=$interval->days;
                $minimum = '-' . $days . ' days';

                $comment = new Comment();
                $comment->setAuthour($faker->name)
                        ->setContent($content)
                        ->setCreatedAt($faker->dateTimeBetween($minimum))
                        ->setActivity($activite);
                $manager->persist($comment);
            
                }

            }

        }
        


        $manager->flush();
    }
}