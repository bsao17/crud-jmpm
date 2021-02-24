<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\BilletRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController
{
    /**
     * @Route("/delete", name="admin_delete")
     * @param BilletRepository $billets
     * @return Response
     */
    public function index(BilletRepository $billets): Response
    {
        return $this->render('delete/index.html.twig', [
            'billets' => $billets->findAll(),
        ]);
    }
}
