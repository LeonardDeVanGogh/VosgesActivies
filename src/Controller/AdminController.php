<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;

/**
 * @Route("/admin", name="admin_")
 */

class AdminController extends AbstractController
{
	 /**
     * @Route("/", name="admin_index")
     */

    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

	 /**
     * @Route("/users", name="admin_users")
     */
    public function usersList(UserRepository $users){
    	return $this->render('admin/users.html.twig', [
    		'users' => $users->findAll()
    	]);
    }
}
