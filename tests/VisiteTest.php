<?php

namespace App\Tests;

use App\Entity\Environnement;
use App\Entity\Visite;
use DateTime;
use PHPUnit\Framework\TestCase;

class VisiteTest extends TestCase{
    public function testGetDatecreationString(){
        $visite = new Visite();
        $visite->setDatecreation(new \DateTime("2024-04-24"));
        $this->assertEquals("24/04/2024", $visite->getDatecreationString());
    }
    public function testAddEnvironnement(){
        $environnement = new Environnement();
        $environnement->setNom("forêt");
        $visite = new Visite();
        $visite->addEnvironnement($environnement);
        $nbEnvironnementBefore = $visite->getEnvironnements()->count();
        $visite->addEnvironnement($environnement);
        $nbEnvironnementAfter = $visite->getEnvironnements()->count();
        $this->assertEquals($nbEnvironnementBefore, $nbEnvironnementAfter, "ajout même environnement devrait échouer");
    }
    }
