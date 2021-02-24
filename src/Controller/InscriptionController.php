<?php

namespace App\Controller;

use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_inscription")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(InscriptionType::class );
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $data = $form->getData();
            $em->persist($data);
        }
        $em->flush();

        return $this->render('inscription/index.html.twig', [
            'formView' => $form->createView()
        ]);
    }
}
