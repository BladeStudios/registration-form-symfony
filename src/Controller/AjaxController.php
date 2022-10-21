<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class AjaxController extends AbstractController
{
    /**
     * @Route("/ajax/voivodeships", name="ajax_voivodeships")
     */
    public function index(Request $request)
    {
        if(!$request->isXMLHttpRequest())
            return new Response('Cannot use a method without an AJAX call.');

        $url = 'http://api.dro.nazwa.pl/';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL,$url);
        $result=curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        if ($info['http_code'] === 200) {
            $response = new JsonResponse();
            $response->setContent($result);
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }

        return new JsonResponse([]);
    }
}
