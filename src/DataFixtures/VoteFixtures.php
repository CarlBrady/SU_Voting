<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Vote;

class VoteFixtures extends Fixture
{


    public function load(ObjectManager $manager)
    {

        $voteOne = $this->createVote('New Bathrooms', 'JoeBloggs', "This vote proposes that we should request funding for new toilets",'33','2' );
        $voteTwo = $this->createVote('More Food!', 'JoeBloggs', "This vote proposes that we should request a better selection of food at a better rate in the college",'33','9' );
        $manager->persist($voteOne);
        $manager->persist($voteTwo);

        $manager->flush();
    }

    private function createVote($voteTitle,$voteName,$voteDescription, $voteUp, $voteDown):vote
    {
        $vote = new Vote();
        $vote->setTitle($voteTitle);
        $vote->setUsername($voteName);
        $vote->setDescription($voteDescription);
        $vote->setUp($voteUp);
        $vote->setDown($voteDown);
        return $vote;
    }


}
