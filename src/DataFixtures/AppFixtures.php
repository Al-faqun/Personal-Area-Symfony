<?php

namespace App\DataFixtures;

use App\Entity\Cargo;
use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class AppFixtures
 * @package App\DataFixtures
 */
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $num = 20;
        for ($i = 1; $i <= $num; $i++) {
            $randomLength = rand(4, 11);
            $randomName = substr(md5(rand()), 0, $randomLength);
            $date = new \DateTime();
            $cargo = new Cargo($randomName, $date, null);
            $manager->persist($cargo);
        }
        $num =  7;
        for ($i = 1; $i <= $num; $i++) {
            $randomLength = rand(4, 11);
            $randomName = substr(md5(rand()), 0, $randomLength);
            $date = new \DateTime();
            $client = $manager->getRepository(Client::class)->find(1);
            $cargo = new Cargo($randomName, $date, $client);
            $manager->persist($cargo);
        }
        
        
        $manager->flush();
    }
}
