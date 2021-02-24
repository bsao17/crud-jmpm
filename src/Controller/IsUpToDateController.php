<?php

namespace App\Controller;

use App\Form\UpdateType;
use App\Repository\BilletRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IsUpToDateController extends AbstractController
{
    /**
     * @Route("/isupdate", name="is_up_to_date")
     * @param BilletRepository $billetRepository
     * @return Response
     */
    public function index(BilletRepository $billetRepository, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(UpdateType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $data = $form->getData();
            DD($data);
            #$em->persist($data);
        }
        $em->flush();

        return $this->render('is_up_to_date/index.html.twig', [
            'billets' => $billetRepository->findAll(),
            'formView' => $form->createView()
        ]);
    }
}
