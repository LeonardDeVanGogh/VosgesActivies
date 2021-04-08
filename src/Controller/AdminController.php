<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditRoleUserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;

/**
 * @Route("/admin", name="admin_")
 */

class AdminController extends AbstractController
{

	 /**
     * @Route("/users", name="users")
     */
    public function usersList(UserRepository $users){
    	return $this->render('admin/users.html.twig', [
    		'users' => $users->findAll()
    	]);
    }
    /**
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
}
