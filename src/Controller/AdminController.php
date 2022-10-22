<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Client;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\ClientFormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $clients = $doctrine->getRepository(Client::class)->findAll();

        return $this->render('admin/index.html.twig', [
            'clients' => $clients
        ]);
    }

    /**
     * @Route("/admin/delete/{id}", name="admin_delete")
     */
    public function delete(ManagerRegistry $doctrine, Client $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $client = $doctrine->getManager();
        $client->remove($id);
        $client->flush();

        return $this->redirectToRoute('admin');
    }

    /**
     * @Route("/admin/modify/{id}", name="admin_modify")
     */
    public function modify(Request $request, ManagerRegistry $doctrine, $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $client = $doctrine->getRepository(Client::class)->find($id);
        $form = $this->createForm(ClientFormType::class, $client);

        $form->add('voivodeship', TextType::class, [
            'label' => 'Województwo:'
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($client);
            $entityManager->flush();
            $this->addFlash('success', 'Pomyślnie zmodyfikowano rekord!');
            return $this->redirectToRoute('admin_modify',[
                'id' => $id
            ]);
        }

        return $this->render('admin/modify.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
