<?php

namespace App\Controller\Admin;

use App\Entity\Property;
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
     * @Route("/admin", name="admin_property_index")
     */
    public function index()
    {
        $properties = $this->repo->findAll();
        return $this->render('admin/property/index.html.twig', [
            'properties' => $properties,
        ]);
    }
    /**
     * @Route("/admin/{id}/edit", name="admin_property_edit")
     */
    public function edit(Property $property)
    {
        
        return $this->render('admin/property/edit.html.twig', [
            'property' => $property,
        ]);
    }
}
