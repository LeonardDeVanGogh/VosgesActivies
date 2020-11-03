<?php

namespace App\Controller;

use App\Entity\ReportReason;
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
use App\Entity\Report;

use App\Form\CommentType;
use App\Form\ReportType;

use App\Form\ActivityType;
use App\Repository\ActivityRepository;
use App\Repository\CategoryRepository;
use App\Repository\ReportRepository;
use App\Repository\ReportReasonRepository;


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


            if(!$activity->getId()){
                $activity->setUser($this->getUser());
                $activity->setCreatedAt(new \Datetime());
                $manager->persist($activity);
            }else{

                $activity->setUpdatedAt(new \Datetime());
                $activity->setUpdatedBy($this->getUser()->getId());
            }
            

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
    public function show(Activity $activity, Request $request, EntityManagerInterface $manager, ReportReasonRepository $repo)
    {
        $comment = new Comment();
        $formComment = $this->createForm(CommentType::class, $comment);
        $formComment->handleRequest($request);
        if($formComment->isSubmitted() && $formComment->isValid()){
            $comment->setCreatedAt(new \DateTime())
                    ->setActivity($activity)
                    ->setUser($this->getUser());

            $manager->persist($comment);
            $manager->flush();
            return $this->redirectToRoute('show', ['id'=>$activity->getId()]);
        }

        $reportReasons = $repo->findAll();

        $report = new Report();
        $formReport = $this->createForm(ReportType::class, $report);
        $formReport->handleRequest($request);

        if($formReport->isSubmitted() && $formReport->isValid()){
            $report->setDate(new \DateTime())

            ;
            $manager->persist($report);
            $manager->flush();
            return $this->redirectToRoute('show', ['id'=>$activity->getId()]);
        }

    	return $this->render('activity/show.html.twig',[
    		'activity' => $activity,
            'reportReasons' => $reportReasons,
            'commentForm' => $formComment->createView(),
            'reportForm' => $formReport->createView()
    		]);

    }
    /**
     * @Route("/activity/test", name="test")
     */
    public function test(Request $request)
    {
    $comment = new Comment();
        $report = new Report();
        $formReport = $this->createForm(ReportType::class, $report);
        $formReport->handleRequest($request);

        return $this->render('activity/test.html.twig',[
            'reportForm' => $formReport->createView()

        ]);
    }


    /**
     * @Route("/activity/manage", name="activity_manage")
     */
    public function manage(ActivityRepository $repo)
    {
        $activities = $repo->findActivitiesByUser($this->getUser());
        return $this->render('activity/manage.html.twig', [
            'controller_name' => 'ActivityController',
            'activities'=> $activities,
        ]);
    }

    /**
     * @Route("/activity/{id}/delete", name="activity_delete")
     */
    public function delete(Activity $activity, Request $request, EntityManagerInterface $manager)
    {
        $activity->setDeletedAt(new \DateTime());
        $manager->persist($activity);
        $manager->flush();
        return $this->redirectToRoute('activity');
    }


}
