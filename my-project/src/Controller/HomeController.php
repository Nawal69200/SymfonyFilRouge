<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher): Response
    {
        /*
        $user = new User();
         
        $user->setEmail('john@doe.fr')
    
        ->setUsername('JohnDoe')
    
        ->setPassword($hasher->hashPassword($user, '0000'))
    
        ->setRoles([]);
    
        $em->persist($user);
    
        $em->flush();*/
                   
        return $this->render('home/index.html.twig');
    }
}
