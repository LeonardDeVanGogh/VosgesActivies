<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Activity;
use App\Entity\Category;
use App\Entity\Comment;
use App\Form\CommentType;

use App\Form\ActivityType;
use App\Repository\ActivityRepository;
use App\Repository\CategoryRepository;


class ActivityController extends AbstractController
{
    /**
     * @Route("/Activity", name="activity")
     */
    public function index(ActivityRepository $repo)
    {
    	$activities = $repo->findAllActivities();
        return $this->render('activity/index.html.twig', [
            'controller_name' => 'ActivityController',
            'activities'=> $activities,
        ]);
    }
    /**
    * @Route("/", name="home")
    */
    public function home()
    {
    	return $this->render('activity/home.html.twig', [
        ]);
    }
    /**
    * @Route("/activity/new", name="activity_create")
    * @Route("/activity/{id}/edit", name="activity_edit")
    */
    public function form(Activity $activity = null, Request $request, EntityManagerInterface $manager){

        if(!$activity){
            $activity = new Activity();
        }

        $form = $this->createForm(ActivityType::class,$activity);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isvalid()){
            $user = new User();
            $user->setEmail("test@gmail.com")
                ->setUsername("test")
                ->setPassword('test');
            $manager->persist($user);

            if(!$activity->getId()){
                $activity->setUser($user);
                $activity->setCreatedAt(new \Datetime());
            }else{
                $activity->setUpdatedAt(new \Datetime());
                $activity->setUpdatedBy(1);
            }
            
            $manager->persist($activity);
            $manager->flush();
            return $this->redirectToRoute('show', ['id' => $activity->getId()]);
        }
        return $this->render('activity/create.html.twig',[
            'formActivity' => $form->createView(),
            'editMode' => $activity->getId() !== null
            ]);
    }
    /**
     * @Route("/activity/show/{id}", name="show")
     */
    public function show(Activity $activity, Request $request, EntityManagerInterface $manager)
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $comment->setCreatedAt(new \DateTime())
                    ->setActivity($activity);

            $manager->persist($comment);
            $manager->flush();
            return $this->redirectToRoute('show', ['id'=>$activity->getId()]);
        }
    	return $this->render('activity/show.html.twig',[
    		'activity'=>$activity,
            'commentForm' => $form->createView()
    		]);

    }

}
