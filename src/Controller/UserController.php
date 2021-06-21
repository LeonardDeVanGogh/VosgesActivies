<?php

namespace App\Controller;

use App\Form\UserUpdateType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class UserController extends AbstractController
{
    /**
     * @Route("/user/update", name="user_update", methods={"GET", "POST"})
     * @IsGranted("ROLE_USER")
     */
    public function userUpdate(Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(UserUpdateType::class, $this->getUser());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();
        }

        return $this->render('user/edit_user.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }
}
