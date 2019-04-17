<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\ConfirmVote;

class ConfirmVoteFixtures extends Fixture
{


    public function load(ObjectManager $manager)
    {
        $date= new \DateTime('@'.strtotime('now'));

        $conVoteOne = $this->createConVote('New Bathrooms', "This vote proposes that we should request funding for new toilets", $date );
        $conVoteTwo = $this->createConVote('More Food!', "This vote proposes that we should request a better selection of food at a better rate in the college", $date );
        $manager->persist($conVoteOne);
        $manager->persist($conVoteTwo);

        $manager->flush();
    }

    private function createConVote($voteTitle,$voteDescription, $voteDate):Confirmvote
    {
        $conVote = new ConfirmVote();
        $conVote->setTitle($voteTitle);
        $conVote->setDescription($voteDescription);
        $conVote->setDate($voteDate);
        return $conVote;
    }


}
