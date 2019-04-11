<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin_index")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', []);
    }

    /**
     * @Route("/home", name="admin_home")
     * @IsGranted("ROLE_ADMIN")
     */
    public function home()
    {
        return $this->render('admin/home.html.twig', []);
    }
    /**
     * @Route("/admin_about", name="admin_about")
     * @IsGranted("ROLE_ADMIN")
     */
    public function about()
    {
        return $this->render('admin/about_admin.html.twig', []);
    }
}
