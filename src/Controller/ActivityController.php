<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\Comment;
use App\Entity\Report;
use App\Form\ActivityType;
use App\Form\CommentType;
use App\Form\ReportType;
use App\Formatter\ActivityToJsonFormatter;
use App\Repository\ActivityRepository;
use App\Repository\CategoryRepository;
use App\Repository\CommentRepository;
use App\Repository\ReportReasonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class ActivityController extends AbstractController
{
    /** @var ActivityToJsonFormatter */
    private $activityToJsonFormatter;

    public function __construct(ActivityToJsonFormatter $activityToJsonFormatter)
    {
        $this->activityToJsonFormatter = $activityToJsonFormatter;
    }

    /**
     * @Route("/Activity", name="activity")
     */
    public function index(
        ActivityRepository $activityRepository,
        CategoryRepository $categoryRepository
    ) {
    	$activities = $activityRepository->findAllActivities();
        $activitiesJson = $this->activityToJsonFormatter->format($activities);
    	$categories = $categoryRepository->findAllCategoriesNotDeleted();
        return $this->render('activity/index.html.twig', [
            'controller_name' => 'ActivityController',
            'activities'=> $activities,
            'categories'=> $categories,
            'activitiesJson'=> json_encode($activitiesJson, JSON_UNESCAPED_UNICODE),
        ]);
    }
    /**
    * @Route("/", name="home")
    */
    public function home(ActivityRepository $activityRepository )
    {
        $lastActivities = $activityRepository->findLastActivitiesCreated();

    	return $this->render('activity/home.html.twig', [
    	    'lastActivities' => $lastActivities,
        ]);
    }

    /**
    * @isGranted("ROLE_EDITOR")
    * @Route("/activity/{id}/edit", name="activity_edit")
    */
    public function update(Activity $activity, Request $request, EntityManagerInterface $manager, SluggerInterface $slugger){

        $form = $this->createForm(ActivityType::class,$activity);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isvalid()){

            $activity->setUpdatedAt();
            $activity->setUpdatedBy($this->getUser()->getId());
            $picture = $form->get('picture')->getData();
            if($picture !== null){
                $originalPictureName = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                $safePictureName = $slugger->slug($originalPictureName);
                if($activity->getPicture() !== 'activity_default.jpg'){
                    $newPictureName = $activity->getPicture();
                }else{
                    $newPictureName = $safePictureName.'-'.uniqid().'.'.$picture->guessExtension();
                }
                try {
                    $picture->move(
                        $this->getParameter('images_directory'),
                        $newPictureName
                    );
                } catch (FileException $e) {

                }
                $activity->setPicture($newPictureName);
                $manager->persist($activity);
                $manager->flush();
            }

            $manager->flush();
            return $this->redirectToRoute('read', ['id' => $activity->getId()]);
        }
        return $this->render('activity/create.html.twig',[
            'formActivity' => $form->createView(),
            'editMode' => $activity->getId() !== null
            ]);
    }

    /**
     * @isGranted("ROLE_EDITOR")
     * @Route("/activity/new", name="activity_create")
     */
    public function create(Request $request, EntityManagerInterface $manager, SluggerInterface $slugger){

        $activity = new Activity();

        $form = $this->createForm(ActivityType::class,$activity);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isvalid()){

            $activity->setUser($this->getUser());
            $activity->setCreatedAt();
            $activity->setPicture('activity_default.jpg');
            $manager->persist($activity);
            $manager->flush();

            $picture = $form->get('picture')->getData();
            if($picture !== null){
                $originalPictureName = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                $safePictureName = $slugger->slug($originalPictureName);
                $newPictureName = $safePictureName.'-'.uniqid().'.'.$picture->guessExtension();
                try {
                    $picture->move(
                        $this->getParameter('images_directory'),
                        $newPictureName
                    );
                } catch (FileException $e) {

                }
                $activity->setPicture($newPictureName);
                $manager->persist($activity);
                $manager->flush();
            }
            return $this->redirectToRoute('read', ['id' => $activity->getId()]);
        }
        return $this->render('activity/create.html.twig',[
            'formActivity' => $form->createView(),
            'editMode' => $activity->getId() !== null
        ]);
    }
    /**
     * @Route("/activity/read/{id}", name="read")
     */
    public function show(Activity $activity, Request $request, EntityManagerInterface $manager, CommentRepository $repo)
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
            return $this->redirectToRoute('read', ['id'=>$activity->getId()]);
        }

        $report = new Report();
        $formReport = $this->createForm(ReportType::class, $report);
        $formReport->handleRequest($request);
        if($formReport->isSubmitted() && $formReport->isValid()){
            $myComment = $repo->find($request->request->get('comment_id'));
            $report->setComment($myComment);
            $report->setUser($this->getUser());
            $manager->persist($report);
            $manager->flush();
            return $this->redirectToRoute('read', ['id'=>$activity->getId()]);
        }

    	return $this->render('activity/show.html.twig',[
    		'activity' => $activity,
            'commentForm' => $formComment->createView(),
            'reportForm' => $formReport->createView()
    		]);

    }
    /**
     * @Route("/Activity/test", name="test")
     */
    public function test()
    {
        return $this->render('activity/test.html.twig');
    }


    /**
     * @isGranted("ROLE_EDITOR")
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
