<?php

namespace App\DataFixtures;

use App\Entity\EventCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CategoryFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $role = [
            'DT',
            'RPP',
            'RPAF',
            'Cleo-T',
            'Sec-T',
            'Treso-T',
        ];
        $faker = Faker\Factory::create();
        $count = 0;
        for ($i = 0; $i <= 10; $i++) {
            $category = new EventCategory();
            $category->setLabel('Category'.$i+1);
            $category->setDescription($faker->text);
            $category->setStatus(rand(true, false));
            $category->setDefaultValueIsVisible(rand(true, false));
            $key = array_rand($role);
            $category->addFonction($this->getReference(sprintf('role-%s-%s', $role[$key], '')));
            $category->addFonctionAccreditation($this->getReference(sprintf('role-%s-%s', $role[$key], '')));
            $manager->persist($category);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            RoleFixture::class,
        ];
    }
}
