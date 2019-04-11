<?php

namespace App\Controller;

use App\Entity\ConfirmVote;
use App\Form\ConfirmVoteType;
use App\Repository\ConfirmVoteRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/confirm/vote")
 *
 */
class ConfirmVoteController extends AbstractController
{
    /**
     * @Route("/", name="confirm_vote_index", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(ConfirmVoteRepository $confirmVoteRepository): Response
    {
        return $this->render('confirm_vote/index.html.twig', [
            'confirm_votes' => $confirmVoteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/default_index", name="confirm_vote_default_index", methods={"GET"})
     */
    public function default_index(ConfirmVoteRepository $confirmVoteRepository): Response
    {
        return $this->render('confirm_vote/default_index.html.twig', [
            'confirm_votes' => $confirmVoteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/default_user", name="confirm_vote_user_index", methods={"GET"})
     *  @IsGranted("ROLE_USER")
     */
    public function user_index(ConfirmVoteRepository $confirmVoteRepository): Response
    {
        return $this->render('confirm_vote/user_index.html.twig', [
            'confirm_votes' => $confirmVoteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="confirm_vote_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response
    {
        $confirmVote = new ConfirmVote();
        $form = $this->createForm(ConfirmVoteType::class, $confirmVote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($confirmVote);
            $entityManager->flush();

            return $this->redirectToRoute('confirm_vote_index');
        }

        return $this->render('confirm_vote/new.html.twig', [
            'confirm_vote' => $confirmVote,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/default/{id}", name="confirm_vote_show_default", methods={"GET"})
     */
    public function showDefault(ConfirmVote $confirmVote): Response
    {
        return $this->render('confirm_vote/show_default.html.twig', [
            'confirm_vote' => $confirmVote,
        ]);
    }

    /**
     * @Route("/{id}", name="confirm_vote_show", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function show(ConfirmVote $confirmVote): Response
    {
        return $this->render('confirm_vote/show.html.twig', [
            'confirm_vote' => $confirmVote,
        ]);
    }
    /**
     * @Route("/user/{id}", name="confirm_vote_show_user", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function showUser(ConfirmVote $confirmVote): Response
    {
        return $this->render('confirm_vote/show_user.html.twig', [
            'confirm_vote' => $confirmVote,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="confirm_vote_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, ConfirmVote $confirmVote): Response
    {
        $form = $this->createForm(ConfirmVoteType::class, $confirmVote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('confirm_vote_index', [
                'id' => $confirmVote->getId(),
            ]);
        }

        return $this->render('confirm_vote/edit.html.twig', [
            'confirm_vote' => $confirmVote,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="confirm_vote_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, ConfirmVote $confirmVote): Response
    {
        if ($this->isCsrfTokenValid('delete'.$confirmVote->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($confirmVote);
            $entityManager->flush();
        }

        return $this->redirectToRoute('confirm_vote_index');
    }
}
