<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserUpdateType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class UserController extends AbstractController
{
    /**
     * @isGranted("ROLE_USER")
     * @Route("/user/update/{id}", name="user_update")
     */
    public function userUpdate(User $user, Request $request){

        $form = $this->createForm(UserUpdateType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        }
        return $this->render('user/edit_user.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }
}
