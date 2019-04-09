<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        $numUsers = 50;
        for ($i=0; $i < $numUsers; $i++) {
            $userName = $faker->userName;
            $userFirstName = $faker->firstName;
            $userLastName = $faker->lastName;
            $userEmail = $faker->email;
            $userPass = $faker->password;
            $userRole = $faker->randomElements(['ROLE_ADMIN', 'ROLE_USER']);
            $userCampus = $faker->randomElement(['Science', 'Business', 'Horticulture', 'Social Studies', 'Engineering']);


            $user = new user();
            $user->setUsername($userName);
            $user->setFirstName($userFirstName);
            $user->setLastName($userLastName);
            $user->setEmail($userEmail);
            $user->setCampus($userCampus);
            $encodedPassword = $this->passwordEncoder->encodePassword($user, $userPass);
            $user->setPassword($encodedPassword);
            $user->setRoles($userRole);

            $manager->persist($user);
        }
        $userAdmin = $this->createUser('User','User', 'user@user.com', 'Science ', 'user', 'user',  ['ROLE_USER'] );
        $userUser = $this->createUser('Admin','Admin', 'admin@user.com','Science', 'admin', 'admin', ['ROLE_ADMIN']);

        $manager->persist($userAdmin);
        $manager->persist($userUser);

        $manager->flush();
    }

    private function createUser($userfname,$userlname,$useremail, $userCampus, $username, $plainPassword, $roles = ['ROLE_USER']):User
    {
        $user = new User();
        $user->setUsername($username);
        $user->setfirstName($userfname);
        $user->setlastName($userlname);
        $user->setCampus($userCampus);
        $user->setemail($useremail);
        $user->setRoles($roles);
        // password - and encoding
        $encodedPassword = $this->passwordEncoder->encodePassword($user, $plainPassword);
        $user->setPassword($encodedPassword);
        return $user;
    }


}
