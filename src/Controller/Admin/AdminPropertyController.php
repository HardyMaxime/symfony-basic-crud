<?php

namespace App\Controller\Admin;

use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminPropertyController extends AbstractController
{

    public function __construct(PropertyRepository $repo)
    {
        $this->repo = $repo;
    }
  
    /**
     * @Route("/admin/property", name="admin_property")
     */
    public function index()
    {
        return $this->render('admin_property/index.html.twig', [
            'controller_name' => 'AdminPropertyController',
        ]);
    }
}
