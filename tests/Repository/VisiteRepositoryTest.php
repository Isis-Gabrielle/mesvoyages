<?php

namespace App\Tests\Repository;

use App\Entity\Visite;
use App\Repository\VisiteRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class VisiteRepositoryTest extends KernelTestCase {

    public function recupRepository(): VisiteRepository {
        self::bootKernel();
        $repository = self::getContainer()->get(VisiteRepository::class);
        return $repository;
    }

    public function testNbVisites() {
        $repository = $this->recupRepository();
        $nbVisites = $repository->count([]);
        $this->assertEquals(99, $nbVisites);
    }
    
    public function newVisite(): Visite {
        $visite = (new Visite())
                        ->setVille("New York")
                        ->setPays("USA")
                        ->setDateCreation(new DateTime("now"));
        return $visite;
    }
    
    public function testRemoveVisite() {
        $repository = $this->recupRepository();
        $visite = $this->newVisite();
        $repository->add($visite, true);
        $nbVisites = $repository->count([]);
        $repository->remove($visite, true);
        $this->assertEquals($nbVisites - 1, $repository->count([]), "Erreur de suppression");
    }
    public function testFindByEqualValue() {
        $repository = $this->recupRepository();
        $visite = $this->newVisite();
        $repository->add($visite, true);
        $visites = $repository->findByEqualValue("ville", "New York");
        $nbVisites = count([$visites]);
        $this->assertEquals(1, $nbVisites);
    }
}
