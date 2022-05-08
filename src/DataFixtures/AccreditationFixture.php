<?php

namespace App\DataFixtures;

use App\Entity\AgeSection;
use App\Entity\Accreditation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use LogicException;

class AccreditationFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $accreditationData = [
            'voir les événements de ma structure',
            'voir les événements des structures enfant',
            'créer un événement',
            'modifier ou supprimer les événements que l’on a créé',
            'modifier les évènements créés par un tiers',
            'modifier les évènements créés par un tiers dans une structure enfant',
            'supprimer les évènements créés par un tiers',
            'supprimer les évènements créés par un tiers dans une structure enfant',
            'personnaliser les fonctions invitées',
            'définir des invitations nominatives',
            'personnaliser la visibilité de l\'événement'
        ];

        $count = 0;

        foreach ($accreditationData as $row) {
            $accreditation = New Accreditation();
            $accreditation->setName($row);
            
            $manager->persist($accreditation);

            $this->setReference(sprintf('accredit-%s', $count), $accreditation);
            $count ++;
        }

        $manager->flush();
    }
}
