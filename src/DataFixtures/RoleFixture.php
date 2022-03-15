<?php

namespace App\DataFixtures;

use App\Entity\AgeSection;
use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use LogicException;

class RoleFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $rolesData = [
            [
                'name' => 'Délégué territorial',
                'feminineName' => 'Déléguée territoriale',
                'code' => 'DT',
            ],
            [
                'name' => 'Responsable du pôle pédagogie',
                'code' => 'RPP',
            ],
            [
                'name' => 'Responsable du pôle administration et finances',
                'code' => 'RPAF',
            ],
            [
                'name' => 'Cleophas territorial',
                'feminineName' => 'Cleophas territoriale',
                'code' => 'Cleo-T',
            ],
            [
                'name' => 'Secrétaire territorial',
                'feminineName' => 'Secrétaire territoriale',
                'code' => 'Sec-T',
            ],
            [
                'name' => 'Trésorier territorial',
                'feminineName' => 'Trésorière territoriale',
                'code' => 'Treso-T',
            ],
            [
                'name' => 'Aumônier territorial',
                'code' => 'Aum-T',
            ],
            [
                'name' => 'Accompagnateur pédagogique',
                'feminineName' => 'Accompagnatrice pédagogique',
                'code' => 'AP',
                'ageSections' => ['FA', 'LJ', 'SG', 'PioK', 'Comp.'],
            ],
            [
                'name' => 'Chargé de mission territorial',
                'feminineName' => 'Chargée de mission territoriale',
                'code' => 'CDM-T',
            ],
            [
                'name' => 'Responsable de Groupe',
                'code' => 'RG',
            ],
            [
                'name' => 'Responsable de Groupe Adjoint',
                'feminineName' => 'Responsable de Groupe Adjointe',
                'code' => 'RGA',
            ],
            [
                'name' => 'Secrétaire de Groupe',
                'code' => 'Sec',
            ],
            [
                'name' => 'Trésorier de Groupe',
                'feminineName' => 'Trésorière de Groupe',
                'code' => 'Treso',
            ],
            [
                'name' => 'Cleophas',
                'code' => 'Cleo',
            ],
            [
                'name' => 'Aumônier de Groupe',
                'code' => 'Aum',
            ],
            [
                'name' => 'Accompagnateur Compagnons',
                'feminineName' => 'Accompagnatrice Compagnons',
                'code' => 'AccoCo',
                'ageSections' => ['Comp.'],
            ],
            [
                'name' => 'Chef d\'unité',
                'feminineName' => 'Cheftaine d\'unité',
                'code' => 'C',
                'ageSections' => ['LJ', 'SG', 'PioK'],
            ],
            [
                'name' => 'Responsable Farfadets',
                'code' => 'RF',
                'ageSections' => ['FA'],
            ],
            [
                'name' => 'Chargé de mission',
                'feminineName' => 'Chargée de mission',
                'code' => 'CDM',
            ],
            [
                'name' => 'Impeesa',
                'code' => 'Imp',
            ],
        ];

        foreach ($rolesData as $row) {
            $role = new Role($row['name'], $row['code'],$row['feminineName'] ?? null);
            $sections = $row['ageSections'] ?? [false];
            foreach ($sections as $section) {
                $ageSectionRef = $section ? sprintf('age-section-%s', $section) : AgeSectionFixture::SUPPORT_ROLE_REF;
                $ageSection = $this->getReference($ageSectionRef);
                if (!$ageSection instanceof AgeSection) {
                    throw new LogicException('Invalid reference to age section');
                }
                $role->addAgeSection($ageSection);
            }
            $manager->persist($role);
        }

        $manager->flush();
    }
}
