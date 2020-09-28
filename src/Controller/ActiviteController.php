<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Activite;
use App\Entity\Category;
use App\ENtity\Comment;
use App\Form\CommentType;

use App\Form\ActivityType;
use App\Repository\ActiviteRepository;
use App\Repository\CategoryRepository;


class ActiviteController extends AbstractController
{
    /**
     * @Route("/Activite", name="activites")
     */
    public function index(ActiviteRepository $repo)
    {
    	$activites = $repo->findAll();
        return $this->render('activite/index.html.twig', [
            'controller_name' => 'ActiviteController',
            'activites'=> $activites,
        ]);
    }
    /**
    * @Route("/", name="home")
    */
    public function home()
    {
    	return $this->render('activite/home.html.twig', [
        ]);
    }
    /**
    * @Route("/activite/new", name="activity_create")
    * @Route("/activite/{id}/edit", name="activity_edit")
    */
    public function form(Activite $activite = null, Request $request, EntityManagerInterface $manager){

        if(!$activite){
            $activite = new Activite();
        }

        $form = $this->createForm(ActivityType::class,$activite);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isvalid()){
            if(!$activite->getId()){
                $activite->setCreatedAt(new \Datetime());
            }
            
            $manager->persist($activite);
            $manager->flush();
            return $this->redirectToRoute('show', ['id' => $activite->getId()]);
        }
        return $this->render('activite/create.html.twig',[
            'formActivity' => $form->createView(),
            'editMode' => $activite->getId() !== null
            ]);
    }
    /**
     * @Route("/activite/show/{id}", name="show")
     */
    public function show(Activite $activite, Request $request, EntityManagerInterface $manager)
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $comment->setCreatedAt(new \DateTime())
                    ->setActivity($activite);

            $manager->persist($comment);
            $manager->flush();
            return $this->redirectToRoute('show', ['id'=>$activite->getId()]);
        }
    	return $this->render('activite/show.html.twig',[
    		'activite'=>$activite,
            'commentForm' => $form->createView()
    		]);

    }

}
