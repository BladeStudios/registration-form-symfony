<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Client;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\ClientFormType;

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
    public function modify(ManagerRegistry $doctrine, $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $client = $doctrine->getRepository(Client::class)->find($id);
        $form = $this->createForm(ClientFormType::class, $client, array('method' => 'PUT'));

        if($form->isSubmitted() && $form->isValid())
        {
            //TODO
        }

        return $this->render('admin/index.html.twig', [
            'id' => $id,
            'client' => $client,
            'form' => $form->createView()
        ]);
    }
}
