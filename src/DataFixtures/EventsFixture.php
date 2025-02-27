<?php

namespace App\DataFixtures;

use App\Entity\Events;
use App\Entity\EventCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Monolog\DateTimeImmutable;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EventsFixture extends Fixture implements DependentFixtureInterface
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
        $structure = [
            '000',
            '100',
            '1000',
            '1001',
            '1002',
            '1003',
            '1004',
            '1005',
            '1006',
            '1007',
            '2000',
            '2001',
            '2002',
            '2003',
            '2004',
            '2005',
            '2006',
            '7000',
            '7001',
            '7002',
            '7003',
            '7004',
            '7005',
            '7006',
            '7007',
        ];
        $faker = Faker\Factory::create();
        $count = 0;
        for ($i=0; $i < 50; $i++) { 
            $event = new Events();
            $event->setTitle('Event'.$i+1);
            $event->setStartAt(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-6 months', '+1 year')));
            $event->setEndAt(DateTimeImmutable::createFromMutable($faker->dateTimeBetween($event->getStartAt()->format('Y-m-d H:i:s').'+1 hour',  $event->getStartAt()->format('Y-m-d H:i:s').'+2 days')));
            $event->setDescription($faker->text);
            $event->setCategory($this->getReference(sprintf('category-%s', random_int(0, 10))));

            $key = array_rand($role);
            $code = array_rand($structure);

            $event->addInvitedRole($this->getReference(sprintf('role-%s-%s', $role[$key], '')));
            $event->addLinkedStructure($this->getReference(sprintf('structure-%s', $structure[$code])));
            $event->addInvitedPerson($this->getReference(sprintf('user-%s', random_int(0, 300))));
            $event->setIsVisible(random_int(0, 1));
            $manager->persist($event);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixture::class,
            CategoryFixture::class
        ];
    }
}
