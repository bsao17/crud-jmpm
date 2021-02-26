<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class InscriptionController extends AbstractController
{
    protected $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @Route("/inscription", name="security_inscription")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(InscriptionType::class);
        $form->handleRequest($request);
        $builder = new User;
        $data = $form->getData();
        if ($form->isSubmitted()) {
            $passwordEncoded = $this->encoder->encodePassword($builder, $data->getPassword());
            $builder->setEmail($data->getEmail())
                    ->setPassword($passwordEncoded)
                    ->setUsername($data->getUsername());
            $em->persist($builder);
        }
        $em->flush();

        return $this->render('inscription/index.html.twig', [
            'formView' => $form->createView()
        ]);
    }
}
