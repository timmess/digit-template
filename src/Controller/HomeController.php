<?php

namespace App\Controller;

use App\Entity\Digit;
use App\Form\DigitType;
use App\Service\ClientRequestService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class HomeController extends AbstractController
{
    private ClientRequestService $clientRequestService;

    public function __construct(ClientRequestService $clientRequestService)
    {
        $this->clientRequestService = $clientRequestService;
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    #[Route('/', name: 'app_home')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $digit = new Digit();

        $new_digit_analysis = $this->createForm(DigitType::class, $digit)->handleRequest($request);

        if ($new_digit_analysis->isSubmitted() && $new_digit_analysis->isValid()){
            $text = $new_digit_analysis->getData()->getText();
            $methods = $new_digit_analysis->getData()->getMethods();
            $res = $this->clientRequestService->request($text, $methods);
        }

        return $this->render('home/index.html.twig', [
            "form" => $new_digit_analysis->createView(),
            "res" => $res ?? null
        ]);
    }
}
