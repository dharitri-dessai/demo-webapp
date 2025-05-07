<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;

class CategoryFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $category = new Category();
        $category->setName('Electronics');
        $manager->persist($category);

        $category = new Category();
        $category->setName('Clothing');
        $manager->persist($category);

        $category = new Category();
        $category->setName('Food');
        $manager->persist($category);

        $manager->flush();
    }
}
