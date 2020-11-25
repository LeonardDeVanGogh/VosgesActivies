<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ReportRepository;
use App\Entity\Report;

class ReportController extends AbstractController
{
    /**
     * @Route("/report", name="report")
     */
    public function index()
    {
        return $this->render('report/index.html.twig', [
            'controller_name' => 'ReportController',
        ]);
    }
    /**
     * @Route("/report/create", name="report_create")
     */
    public function create()
    {

        return $this->redirectToRoute();
    }
    /**
     * @Route("/report/moderation", name="report_moderate")
     */
    public function moderation(ReportRepository $repo)
    {
        $reports = $repo->findAllReports();
        return $this->render('report/moderation.html.twig', [
            'controller_name' => 'ReportController',
            'reports' => $reports,
        ]);
    }
}
