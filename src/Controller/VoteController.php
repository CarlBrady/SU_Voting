<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Down;
use App\Entity\Up;
use App\Entity\Vote;
use App\Form\VoteType;
use App\Form\CommentType;
use App\Repository\VoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


/**
 * @Route("/vote")
 */
class VoteController extends AbstractController
{
    /**
     * @Route("/", name="vote_index", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(VoteRepository $voteRepository): Response
    {
        return $this->render('vote/index.html.twig', [
            'votes' => $voteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/user", name="vote_index_user", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function indexUser(VoteRepository $voteRepository): Response
    {
        return $this->render('vote/user_index.html.twig', [
            'votes' => $voteRepository->findAll(),
        ]);
    }



    /**
     * @Route("/how", name="vote_how", methods={"GET"})
     */
    public function how (VoteRepository $voteRepository): Response
    {
        return $this->render('vote/how.html.twig', [
            'votes' => $voteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/default_index", name="vote_default_index", methods={"GET"})
     */
    public function default_index(VoteRepository $voteRepository): Response
    {
        return $this->render('vote/default_index.html.twig', [
            'votes' => $voteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="vote_new", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function new(Request $request): Response
    {
        $vote = new Vote();
        $form = $this->createForm(VoteType::class, $vote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($vote);
            $entityManager->flush();

            return $this->redirectToRoute('vote_index_user');
        }

        return $this->render('vote/new.html.twig', [
            'vote' => $vote,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/new_comment", name="vote_comment", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function newComment(Request $request, AuthenticationUtils $authenticationUtils, Vote $vote): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        $lastUsername = $authenticationUtils->getLastUsername();
        $comment->setUsername($lastUsername);

        $lastTitle = $vote->getTitle();
        $comment->setVote($lastTitle);


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('comment_index');
        }

        return $this->render('comment/new.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="vote_show", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function show(Vote $vote): Response
    {
        return $this->render('vote/show.html.twig', [
            'vote' => $vote,
        ]);
    }

    /**
     * @Route("/user/{id}", name="vote_show_user", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function showUser(Vote $vote): Response
    {
        return $this->render('vote/show_user.html.twig', [
            'vote' => $vote,
        ]);
    }
    /**
     * @Route("/user/{id}/error", name="vote_show_user_error", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function showUserError(Vote $vote): Response
    {
        return $this->render('vote/show_user_error.html.twig', [
            'vote' => $vote,
        ]);
    }
    /**
     * @Route("/default/{id}", name="vote_show_default", methods={"GET"})
     *
     */
    public function showDefault(Vote $vote): Response
    {
        return $this->render('vote/show_default.html.twig', [
            'vote' => $vote,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="vote_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Vote $vote): Response
    {
        $form = $this->createForm(VoteType::class, $vote);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vote_index', [
                'id' => $vote->getId(),
            ]);
        }

        return $this->render('vote/edit.html.twig', [
            'vote' => $vote,
            'form' => $form->createView(),
        ]); }

    /**
     * @Route("/{id}/up", name="vote_up", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function voteUp(Vote $vote): Response
    {

        $repositoryUp = $this->getDoctrine()->getRepository(Up::class);
        $username = $repositoryUp->findOneBy(['username' => $vote->getUsername()]);
        $title = $repositoryUp->findOneBy(['title' => $vote->getTitle()]);

        $repositoryDown = $this->getDoctrine()->getRepository(Down::class);
        $usernameDown = $repositoryDown->findOneBy(['username' => $vote->getUsername()]);
        $titleDown = $repositoryDown->findOneBy(['title' => $vote->getTitle()]);

        $pageUsername = $vote->getUsername();
        $pageTitle = $vote->getTitle();

        if(($title==null or $username==null) and ($titleDown!=null && $usernameDown!=null)){


            return $this->redirectToRoute('vote_show_user_error', array('id' => $vote->getId()));
        }

       else if(($title==null or $username==null) and ($usernameDown==null or $usernameDown==null)){

            $voteUp = $vote->getUp();
            $vote->setUp($voteUp + 1);

            $up = new Up();
            $up->setTitle($vote->getTitle());
            $up->setUsername($vote->getUsername());
            $up->setVoteUp(+1);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($up);
            $entityManager->flush();

            return $this->redirectToRoute('vote_show_user', array('id' => $vote->getId()));
        }

        else if((strcmp($pageTitle,$title->getTitle())==0) && (strcmp($pageUsername,$username->getUsername())==0)){

            return $this->redirectToRoute('vote_show_user_error', array('id' => $vote->getId()));
        }
        else if((strcmp($pageTitle,$titleDown->getTitle())==0) && (strcmp($pageUsername,$usernameDown->getUsername())==0)){

            return $this->redirectToRoute('vote_show_user_error', array('id' => $vote->getId()));
        }
        else {

            $voteUp = $vote->getUp();
            $vote->setUp($voteUp + 1);

            $up = new Up();
            $up->setTitle($vote->getTitle());
            $up->setUsername($vote->getUsername());
            $up->setVoteUp(+1);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($up);
            $entityManager->flush();

            return $this->redirectToRoute('vote_show_user', array('id' => $vote->getId()));
        }
    }

    /**
     * @Route("/{id}/down", name="vote_down", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function voteDown(Vote $vote): Response
    {
        $repository = $this->getDoctrine()->getRepository(Down::class);
        $username = $repository->findOneBy(['username' => $vote->getUsername()]);
        $title = $repository->findOneBy(['title' => $vote->getTitle()]);

        $repositoryUp = $this->getDoctrine()->getRepository(Up::class);
        $usernameUp = $repositoryUp->findOneBy(['username' => $vote->getUsername()]);
        $titleUp = $repositoryUp->findOneBy(['title' => $vote->getTitle()]);

        $pageUsername = $vote->getUsername();
        $pageTitle = $vote->getTitle();

        if(($title==null or $username==null) and ($titleUp==null or $usernameUp==null)){

            $voteDown = $vote->getDown();
            $vote->setDown($voteDown + 1);

            $down = new Down();
            $down->setTitle($vote->getTitle());
            $down->setUsername($vote->getUsername());
            $down->setVoteDown(+1);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($down);
            $entityManager->flush();

            return $this->redirectToRoute('vote_show_user', array('id' => $vote->getId()));
        }

        else if(($title==null or $username==null) and ($titleUp!=null && $usernameUp!=null)){

            return $this->redirectToRoute('vote_show_user_error', array('id' => $vote->getId()));
        }


        else if((strcmp($pageTitle,$title->getTitle())==0) && (strcmp($pageUsername,$username->getUsername())==0)){

            return $this->redirectToRoute('vote_show_user_error', array('id' => $vote->getId()));
        }
        else if((strcmp($pageTitle,$titleUp->getTitle())==0) && (strcmp($pageUsername,$usernameUp->getUsername())==0)){

            return $this->redirectToRoute('vote_show_user_error', array('id' => $vote->getId()));
        }
        else {
            $voteDown = $vote->getDown();
            $vote->setDown($voteDown + 1);

            $down = new Down();
            $down->setTitle($vote->getTitle());
            $down->setUsername($vote->getUsername());
            $down->setVoteDown(+1);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($down);
            $entityManager->flush();

            return $this->redirectToRoute('vote_show_user', array('id' => $vote->getId()));

        }
    }

    /**
     * @Route("/{id}", name="vote_delete", methods={"DELETE"})
     * @IsGranted("ROLE_USER")
     */
    public function delete(Request $request, Vote $vote): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vote->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($vote);
            $entityManager->flush();
        }

        return $this->redirectToRoute('vote_index');
    }
}
