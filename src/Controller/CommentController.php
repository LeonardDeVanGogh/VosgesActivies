<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CommentRepository;
use App\Entity\Comment;

class CommentController extends AbstractController
{
    /**
     * @Route("/comment", name="comment")
     */
    public function index()
    {
        return $this->render('comment/index.html.twig', [
            'controller_name' => 'CommentController',
        ]);
    }
    /**
     * @Route("/comment/moderation", name="comment_moderate")
     */
    public function moderation(CommentRepository $repo)
    {
        $comments = $repo->findAllReportedComment();
        return $this->render('comment/moderation.html.twig', [
            'comments' => $comments,
        ]);
    }
    /**
     * @Route("/comment/{id}/validate", name="comment_validate")
     */
    public function delete(Comment $comment, EntityManagerInterface $manager)
    {
        $comment->setModeratedAt(new \DateTime());
        $manager->persist($comment);
        $manager->flush();
        return $this->redirectToRoute('comment_moderate');
    }
}
