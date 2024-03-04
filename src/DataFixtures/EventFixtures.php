<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use DateTime;


class EventFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 50; $i++) {
            $event = new Event();
            $event->setEventName($faker->sentence);
            $event->setAddress($faker->address);
            $event->setDate(new DateTime($faker->date())); // Assuming $faker->date() returns a string date
            $event->setTime(new DateTime($faker->time()));
            $event->setLocation($faker->city);
            $event->setObjective($faker->sentence);
            $event->setDescription($faker->paragraph);
            $event->setImage($faker->imageUrl());
            
            // Assuming you have categories stored in the database, you can fetch one randomly
            $categorie = $this->getReference('categorie_'. $faker->numberBetween(1, 8));
            $event->setCategory($categorie);            

            $manager->persist($event);
        }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
            
        ];
    }
}
