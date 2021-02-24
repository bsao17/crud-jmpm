<?php

namespace App\Controller;

use App\Entity\Billet;
use App\Form\CreateBilletType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateController extends AbstractController
{
    /**
     * @Route("/create", name="admin_create")
     * @param FormFactoryInterface $factory
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function Create(FormFactoryInterface $factory, Request $request, EntityManagerInterface $em): Response
    {
        $builder = $factory->createBuilder(CreateBilletType::class);

        $form = $builder->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $data = $form->getData();
            $billet = new Billet();
            $billet->setTitle($data->getTitle())
                ->setContent($data->getContent())
                ->setDate($data->getDate())
                ->setAuthors($data->getAuthors())
                ->setPicture($data->getPicture());
            #DD($billet);
            $em->persist($billet);
        }
        $em->flush();

        return $this->render('create/index.html.twig', [
            'formView' => $form->createView()
        ]);
    }
}
