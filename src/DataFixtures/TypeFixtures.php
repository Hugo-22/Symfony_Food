<?php

namespace App\DataFixtures;

use App\Entity\Aliment;
use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TypeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $t1 = new Type();
        $t1->setLibelle("Fruits")
           ->setImage("fruits.jpg");
        $manager->persist($t1);

        $t2 = new Type();
        $t2->setLibelle("Légumes")
           ->setImage("legumes.jpg");
        $manager->persist($t2);

        $alimentRepo = $manager->getRepository(Aliment::class);

        $a1 = $alimentRepo->findOneBy(["nom" => "Carotte"]);
        $a1->setType($t2);
        $manager->persist($a1);

        $a2 = $alimentRepo->findOneBy(["nom" => "Tomate"]);
        $a2->setType($t2);
        $manager->persist($a2);

        $a3 = $alimentRepo->findOneBy(["nom" => "Patate"]);
        $a3->setType($t2);
        $manager->persist($a3);

        $a4 = $alimentRepo->findOneBy(["nom" => "Pomme"]);
        $a4->setType($t1);
        $manager->persist($a4);
       
        $manager->flush();
    }
}
