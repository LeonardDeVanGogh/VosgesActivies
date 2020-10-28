<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Activity;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\User;


class ActiviteFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');
        $user = new User();
        $user->setEmail($faker->email())
            ->setUsername($faker->name())
            ->setPassword('test')
            ->getActivites('activite');
        $manager->persist($user);

        $manager->flush();

        $faker = \Faker\Factory::create('fr_FR');

        //Créer 3 catégories

        for ($i=1;$i<=3;$i++){
            $category = new Category();
            $category->setName($faker->sentence())
                     ->setDescription($faker->paragraph());
            $manager->persist($category);


        //Créer entre 4 et 6 activités
            for($j=1;$j<=mt_rand(4,6);$j++){
            $activite = new Activity();
            $user = new User();
            $user->setEmail($faker->email())
                ->setUsername($faker->name())
                ->setPassword('test')
                ->getActivites('activite');
            $manager->persist($user);

            $content = '<p>' . join($faker->paragraphs(5), '</p><p>') . '</p>';
            $activite->setName($faker->sentence())
                     ->setDescription($content)
                     ->setLatitude(48.070759)
                     ->setLongitude(6.866638)
                     ->setPicture($faker->imageUrl())
                     ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                     ->setCity("Gerardmer")
                     ->setZipcode(88400)
                     ->setStreet("Rue du Lac")
                     ->setStreetNumber(1)
                     ->setIsIndoor(0)
                     ->setIsOutdoor(1)
                     ->setAnimals(0)
                     ->setIsHandicaped(1)
                     ->setUser($user)
            ;

            $manager->persist($activite);


            
            for($l=1;$l<=mt_rand(4,10);$l++){
                $content = '<p>' . join($faker->paragraphs(2), '</p><p>') . '</p>';
                $now = new \DateTime();
                $interval = $now->diff($activite->getCreatedAt());
                $days=$interval->days;
                $minimum = '-' . $days . ' days';

                $comment = new Comment();
                $comment->setContent($content)
                        ->setCreatedAt($faker->dateTimeBetween($minimum))
                        ->setActivity($activite)
                        ->setUser($user);
                $manager->persist($comment);
            
                }

            }

        }
        


        $manager->flush();
    }
}