<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixture extends BaseFixture
{
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany( 'main_users', 10, function($i) {
            $user = new User();
            $user->setEmail(sprintf('spacebar%d@example.com', $i));#
            $user->setFirstName($this->faker->firstName);

            return $user;
        });

        $manager->flush();
    }
}
