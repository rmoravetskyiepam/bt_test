<?php

namespace App\DataFixtures;

use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RoleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //add user roles configuration
        $manager->persist($this->createCustomerRole());
        $manager->persist($this->createSupportSpecialistRole());
        $manager->persist($this->createSupportManagerRole());


        $manager->flush();
    }

    private function createCustomerRole(): Role
    {
        return (new Role())->setName(Role::CUSTOMER_ROLE)
            ->setCreateCase(true)
            ->setPostComments(true)
            ->setUpdateStatus(false)
            ->setViewCaseComments(true)
            ->setViewStatistic(false)
            ->setViewAllCustomersCases(false);
    }

    private function createSupportSpecialistRole(): Role
    {
        return (new Role())->setName(Role::SUPPORT_SPECIALIST_ROLE)
            ->setCreateCase(false)
            ->setPostComments(true)
            ->setUpdateStatus(true)
            ->setViewCaseComments(true)
            ->setViewStatistic(false)
            ->setViewAllCustomersCases(true);
    }

    private function createSupportManagerRole(): Role
    {
        return (new Role())->setName(Role::ROLE_SUPPORT_MANAGER)
            ->setCreateCase(false)
            ->setPostComments(false)
            ->setUpdateStatus(false)
            ->setViewCaseComments(false)
            ->setViewStatistic(true)
            ->setViewAllCustomersCases(true);
    }
}
