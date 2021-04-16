<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ReportRepository;
use App\Entity\Report;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ReportController extends AbstractController
{

    /**
     * @isGranted("ROLE_MODERATOR")
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
