<?php

namespace App\Controller;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/data", name="api_data")
     */
    public function fetchData()
    {
        $client = new Client(['verify' => false]);

        $body = '{
            "param1": "one",
            "param2": "two"
        }';
        $url = 'https://app.kaze.so/api/some.json';
        $token = getenv('TOKEN_kaze');
        $headers = [
            'Authorization' => $token,
            'Accept' => 'application/json',
        ];
        $request = new Request('GET', $url, $headers, $body);
        $promise = $client->sendAsync($request);
        $promise->then(function ($response) {
            $responseData = $response->getBody()->getContents();

            // var_dump($responseData);
            // die();
            $form = $this->createForm(DevisType::class);

            return $this->render('api/data.html.twig', [
                'data' => $responseData,
                'devistype' => $form->createView()
            ]);
        })->wait();
    }
}
