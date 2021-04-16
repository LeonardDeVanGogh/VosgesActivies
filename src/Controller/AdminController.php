<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditRoleUserType;
use App\Form\UserUpdateType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/admin", name="admin_")
 */

class AdminController extends AbstractController
{

	 /**
      * @isGranted("ROLE_ADMIN")
     * @Route("/users", name="users")
     */
    public function usersList(UserRepository $users){
    	return $this->render('admin/users.html.twig', [
    		'users' => $users->findAll()
    	]);
    }
    /**
     * @isGranted("ROLE_ADMIN")
     * @Route("/user/role/update/{id}", name="user_role_update")
     */
    public function userRoleUpdate(User $user, Request $request){
        $form = $this->createForm(EditRoleUserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('message', 'Utilisateur modifié avec succès');
            return $this->redirectToRoute('admin_users');
        }
        return $this->render('admin/edit_role_user.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }
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
        return $this->render('admin/edit_user.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }
}
