<?php

namespace App\Tests\Validations;

use App\Entity\Visite;
use DateInterval;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class VisiteValidationsTest extends KernelTestCase {

    public function getVisite(): Visite {
        return (new Visite())
                        ->setVille("New York")
                        ->setPays("USA");
    }

    public function assertErrors(Visite $visite, int $nbErreursAttendues, string $message = "") {
        self::bootKernel();
        $validator = self::getContainer()->get(ValidatorInterface::class);
        $error = $validator->validate($visite);
        $this->assertCount($nbErreursAttendues, $error, $message);
    }

    public function testValidNoteVisite() {
        $visite = $this->getVisite()->setNote(10);
        $this->assertErrors($visite, 0, "10 doit être valide");
        $visite = $this->getVisite()->setNote(0);
        $this->assertErrors($visite, 0, "0 doit être valide");
        $visite = $this->getVisite()->setNote(20);
        $this->assertErrors($visite, 0, "20 doit être valide");
    }

    public function testNonValidNoteVisite() {
        $visite = $this->getVisite()->setNote(-1);
        $this->assertErrors($visite, 1, "Note -1 invalide");
        $visite = $this->getVisite()->setNote(21);
        $this->assertErrors($visite, 1, "Note 21 invalide");
        $visite = $this->getVisite()->setNote(-8);
        $this->assertErrors($visite, 1, "Note -8 invalide");
        $visite = $this->getVisite()->setNote(32);
        $this->assertErrors($visite, 1, "Note 32 invalide");
    }

    public function testValidTempmaxVisite() {
        $visite = $this->getVisite()
                ->setTempmin(18)
                ->setTempmax(20);
        $this->assertErrors($visite, 0, "min=18, max=20 doit être valide");
        $visite = $this->getVisite()
                ->setTempmin(19)
                ->setTempmax(20);
        $this->assertErrors($visite, 0, "min=19, max=20 doit être valide");
    }
    public function testNonValidTempmaxVisite() {
        $visite = $this->getVisite()
                ->setTempmin(20)
                ->setTempmax(18);
        $this->assertErrors($visite, 1, "min =20, max=18 devrait échouer");
        $visite = $this->getVisite()
                ->setTempmin(18)
                ->setTempmax(18);
        $this->assertErrors($visite, 1, "min =18, max=18 devrait échouer");
    }
    
    public function testValidDatecreationVisite(){ 
        $today = new DateTime();
        $this->assertErrors($this->getVisite()->setDatecreation($now), 0, "today doit être valide");
        $earlier = (new DateTime())->sub(new DateInterval("P5D"));
        $this->assertErrors($this->getVisite()->setDatecreation($earlier), 0, "earlier doit être valide");
    }
    
    public function testNonValidDatecreationVisite(){ 
        $tomorrow = (new \DateTime())->add(new \DateInterval("P1D"));
        $this->assertErrors($this->getVisite()->setDatecreation($tomorrow), 1, "tomorrow invalide");
        $later = (new \DateTime())->add(new \DateInterval("P5D"));
        $this->assertErrors($this->getVisite()->setDatecreation($later), 1, "later invalide");
    }  
}
