<?php

namespace App\Controller\Admin;

use App\Entity\Type;
use App\Form\TypeType;
use App\Repository\TypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminTypeController extends AbstractController
{
    /**
     * @Route("/admin_type", name="admin_types")
     */
    public function index(TypeRepository $repo)
    {
        $types = $repo->findAll();
        return $this->render('admin_type/adminType.html.twig', [
            'types' => $types
        ]);
    }

    /**
     * @Route("/admin_type/create", name="ajoutType")
     * @Route("/admin_type/{id}", name="modifType", methods="POST|GET")
     */
    public function ajoutEtModif(Type $type = null, HttpFoundationRequest $request, EntityManagerInterface $objectManager)
    {
        if (!$type) {
            $type = new Type();
        }

        $form = $this->createForm(TypeType::class, $type);

        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid()) {
            $objectManager->persist($type);
            $objectManager->flush();
            $this->addFlash('success', "L'action à bien été effectué");
            return $this->redirectToRoute("admin_types");
        }
        return $this->render('admin_type/ajoutEtModif.html.twig', [
            'type' => $type,
            "form" => $form->createView()
        ]);
    }

     /**
     * @Route("/admin_type/{id}", name="supType", methods="delete")
     */
    public function suppresion(Type $type, EntityManagerInterface $objectManager, HttpFoundationRequest $request)
    {
        if ($this->isCsrfTokenValid('SUP'.$type->getId(), $request->get('_token'))) {
            $objectManager->remove($type);
            $objectManager->flush();
            $this->addFlash('success', "L'action à bien été effectué");
            return $this->redirectToRoute("admin_types");
        }
    }
}
