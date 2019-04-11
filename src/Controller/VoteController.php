<?php

namespace App\Controller;

use App\Entity\Vote;
use App\Form\VoteType;
use App\Repository\VoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


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

        $up = $vote->getUp();

        $up = $up + 1;
        $vote->setUp($up);


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($vote);
        $entityManager->flush();


    return $this->redirectToRoute('vote_show_user', array('id' => $vote->getId()));
    }

    /**
     * @Route("/{id}/down", name="vote_down", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function voteDown(Vote $vote): Response
    {
        $down = $vote->getDown();

        $down = $down + 1;
        $vote->setDown($down);


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($vote);
        $entityManager->flush();

    return $this->redirectToRoute('vote_show_user', array('id' => $vote->getId()));
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
