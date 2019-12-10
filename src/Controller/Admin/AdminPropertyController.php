<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPropertyController extends AbstractController
{

    public function __construct(PropertyRepository $repo, EntityManagerInterface $em)
    {
        $this->repo = $repo;
        $this->em = $em;
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
     * @Route("/admin/{id}", name="admin_property_edit", methods="POST|GET" , requirements={"id":"\d+"})
     */
    public function edit(Property $property, Request $req)
    {

        $form = $this->createForm(PropertyType::class, $property);

        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', "Bien modifié avec succès");
            return $this->redirectToRoute('admin_property_index');
        }
        
        return $this->render('admin/property/edit.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/create", name="admin_property_create")
     */
    public function create(Request $req)
    {

        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);

        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($property);
            $this->em->flush();
            $this->addFlash('success', "Bien crée avec succès");
            return $this->redirectToRoute('admin_property_index');
        }

        return $this->render('admin/property/create.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/{id}", name="admin_property_delete", methods="DELETE", requirements={"id":"\d+"})
     */
    public function delete(Property $property, Request $req)
    {
        if($this->isCsrfTokenValid('delete' . $property->getId(), $req->get('_token'))) {
            $this->em->remove($property);
            $this->em->flush();
            $this->addFlash('success', "Bien supprimé avec succès");
        }

        return $this->redirectToRoute("admin_property_index");
    }
}
