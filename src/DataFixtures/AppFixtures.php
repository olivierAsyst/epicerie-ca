<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $category1 = new Category();
        $category1->setName("Poisson");
        $category1->setSlug("poisson");
        $category1->setCreatedAt(new \DateTimeImmutable());    

        $manager->persist($category1);
        $manager->flush();

        $category2 = new Category();
        $category2->setName("Légumes");
        $category2->setSlug("legume");
        $category2->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($category2);
        $manager->flush();
    }
}
