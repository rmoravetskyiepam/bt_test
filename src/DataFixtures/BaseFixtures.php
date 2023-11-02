<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\SupportCase;
use App\Entity\Enum\StatusType;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class BaseFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = $this->createUser();

        $supportCaseOpen = (new SupportCase())->setSummary('Mega Super Problem')
            ->setImageUrl('https://img.freepik.com/free-photo/ultra-detailed-nebula-abstract-wallpaper-4_1562-749.jpg')
            ->setDescription('Mega Important Description. An urgent blocker')
            ->setStatus(StatusType::OPEN)
            ->setCreator($user);

        $supportCaseClosed = (new SupportCase())->setSummary('Not Critical Problem')
            ->setImageUrl('https://www.sciencenews.org/wp-content/uploads/2022/11/Hubble-Pillars-of-Creation.jpg')
            ->setDescription('Warranty eligibility issues')
            ->setStatus(StatusType::FIXED)
            ->setCreator($user);

        $manager->persist($user);
        $manager->persist($supportCaseOpen);
        $manager->persist($supportCaseClosed);

        $manager->flush();
    }

    private function createUser(): User
    {
        return (new User())->setEmail('testKing@test.test')
            ->setUsername('kratos88')
            ->setPassword('super_secret_password');
    }

}
