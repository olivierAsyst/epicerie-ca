<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $em, UserPasswordHasherInterface $hasher): Response
    {
        // $user = new User();
        // $user->setFirstName('Djuma')
        // ->setLastName  ('Djumbe')
        // ->setEmail('djuma@free.fr')
        // ->setPhoneNumber('0999644524')
        // ->setPassword($hasher->hashPassword($user,'333666'))
        // ->setAdress('Ontario, Rue 13')
        // ->setVerified(true)
        // ->setRoles([]);

        // $em->persist($user);
        // $em->flush();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
