<?php

namespace App\Controller;

use App\Entity\ReportReason;
use App\Repository\ReportReasonRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ReportReasonType;


class ReportReasonController extends AbstractController
{
    /**
     * @Route("/report/reason/create", name="report_reason_create")
     */
    public function create(Request $request, EntityManagerInterface $manager, ReportReasonRepository $repo)
    {
        $reportReason = new ReportReason();
        $reportReasonForm = $this->createForm(ReportReasonType::class, $reportReason);
        $reportReasonForm->handleRequest($request);
        if($reportReasonForm->isSubmitted() && $reportReasonForm->isValid()){
            $manager->persist($reportReason);
            $manager->flush();
            return $this->redirectToRoute('report_reason');
        }
        return $this->render('report_reason/createUpdate.html.twig', [
            'formReportReason' => $reportReasonForm->createView(),
            'editMode' => $reportReason->getId() !== null,
        ]);
    }
    /**
     * @Route("/report/reason", name="report_reason")
     */
    public function read(ReportReasonRepository $repo)
    {
        $reasons = $repo->findAllReportReasonNotDeleted();
        return $this->render('report_reason/read.html.twig', [
            'reasons' => $reasons,
        ]);
    }
    /**
     * @Route("/report/reason/{id}/update", name="report_reason_update")
     */
    public function update(ReportReason $reportReason, Request$request, EntityManagerInterface $manager, ReportReasonRepository $repo)
    {

        $reportReasonForm = $this->createForm(ReportReasonType::class, $reportReason);

        $reportReasonForm->handleRequest($request);
        if($reportReasonForm->isSubmitted() && $reportReasonForm->isValid()){
            $manager->flush();
            return $this->redirectToRoute('report_reason');
        }
        return $this->render('report_reason/createUpdate.html.twig', [
            'formReportReason' => $reportReasonForm->createView(),
            'editMode' => $reportReason->getId() !== null,
        ]);
    }
    /**
     * @Route("/report/reason/{id}/delete", name="report_reason_delete")
     */
    public function delete(ReportReason $reportReason, EntityManagerInterface $manager){
        $reportReason->setDeletedAt(new \Datetime);
        $manager->flush();
        return $this->redirectToRoute('report_reason');
    }
}
