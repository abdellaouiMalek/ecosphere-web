<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $category = [
            1 => [
                'name' => 'charity',
            ],
            2 => [
                'name' => 'health',
            ],
            3 => [
                'name' => 'donations',
            ],
            4 => [
                'name' => 'cleaning',
            ],
            5 => [
                'name' => 'recycling',
            ],
            6 => [
                'name' => 'education',
            ],
            7 => [
                'name' => 'expos',
            ],
            8 => [
                'name' => 'sustainability',
            ],
        ];

        foreach($category as $key => $value){
            $categorie = new Category();
            $categorie->setName($value['name']);
            $manager->persist($categorie);

            // Enregistre la catégorie dans une référence
            $this->addReference('categorie_' . $key, $categorie);
        }

        $manager->flush();
    }
}
