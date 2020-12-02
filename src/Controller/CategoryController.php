<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category_create")
     */
    public function create(Request $request, EntityManagerInterface $manager)
    {
        $category = new Category();
        $categoryForm = $this->createForm(CategoryType::class, $category);
        $categoryForm->handleRequest($request);
        if($categoryForm->isSubmitted() && $categoryForm->isValid()){
            $manager->persist($category);
            $manager->flush();
            return $this->redirectToRoute('categories');
        }
        return $this->render('category/createUpdate.html.twig', [
            'formCategory' => $categoryForm->createView(),
            'editMode' => $category->getId() !== null,
        ]);
    }
    /**
     * @Route("/categories", name="categories")
     */
    public function read(CategoryRepository $repo)
    {
        $categories = $repo->findAllCategoriesNotDeleted();
        return $this->render('category/read.html.twig', [
            'categories' => $categories,
        ]);
    }
    /**
     * @Route("/category/{id}/update", name="category_update")
     */
    public function update(Category $category, Request$request, EntityManagerInterface $manager)
    {

        $categoryForm = $this->createForm(categoryType::class, $category);

        $categoryForm->handleRequest($request);
        if($categoryForm->isSubmitted() && $categoryForm->isValid()){
            $manager->flush();
            return $this->redirectToRoute('categories');
        }
        return $this->render('category/createUpdate.html.twig', [
            'formCategory' => $categoryForm->createView(),
            'editMode' => $category->getId() !== null,
        ]);
    }
    /**
     * @Route("/category/{id}/delete", name="category_delete")
     */
    public function delete(Category $category, EntityManagerInterface $manager){
        $category->setDeletedAt(new \Datetime);
        $manager->flush();
        return $this->redirectToRoute('categories');
    }
}
