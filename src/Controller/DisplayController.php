<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Client;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DisplayController extends AbstractController
{
    /**
     * @Route("client/{id}", name="html_view")
     */
    public function htmlView(ManagerRegistry $doctrine, $id): Response
    {
        $client = $doctrine->getRepository(Client::class)->find($id);
        return $this->render('display/index.html.twig', [
            'id' => $id,
            'client' => $client
        ]);
    }

    /**
     * @Route("json/{id}", name="json_view")
     */
    public function jsonView(ManagerRegistry $doctrine, $id): JsonResponse
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $client = $doctrine->getRepository(Client::class)->find($id);

        if(!$client)
            throw new NotFoundHttpException('Not found'); 

        $jsonContent = $serializer->serialize($client, 'json');
        return $this->json(json_decode($jsonContent));
    }
}
