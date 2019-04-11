<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class StudentController extends AbstractController
{
    /**
     * @Route("/student", name="student_index")
     * @IsGranted("ROLE_USER")
     */
    public function index()
    {
        return $this->render('student/index.html.twig', []);
    }

    /**
     * @Route("/student_about", name="student_about")
     * @IsGranted("ROLE_USER")
     */
    public function about()
    {
        return $this->render('student/about.html.twig', []);
    }
}
