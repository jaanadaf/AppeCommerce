<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    // Liste des catégories
    #[Route('/category', name: 'category_list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $categories = $entityManager->getRepository(Category::class)->findAll();

        return $this->render('category/list.html.twig', [
            'categories' => $categories,
        ]);
    }

    // Afficher les détails d'une catégorie
    #[Route('/category/{id}', name: 'category_show')]
    public function show(Category $category): Response
    {
        return $this->render('category/show.html.twig', [
            'category' => $category,
        ]);
    }

    // Éditer une catégorie
    #[Route('/category/edit/{id}', name: 'category_edit')]
    public function edit(Category $category, EntityManagerInterface $entityManager): Response
    {
        // Logique pour éditer la catégorie (généralement avec un formulaire)
        // Par exemple, si vous avez un formulaire d'édition, vous pouvez gérer ça ici.
        
        // Pour le moment, supposons que la catégorie soit modifiée (via un formulaire par exemple).
        
        $entityManager->flush();
        
        return $this->render('category/edit.html.twig', [
            'category' => $category,
        ]);
    }

    // Supprimer une catégorie
    #[Route('/category/delete/{id}', name: 'category_delete')]
    public function delete(Category $category, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($category);
        $entityManager->flush();

        $this->addFlash('success', 'Category deleted successfully');
        
        return $this->redirectToRoute('category_list');
    }

    // Copier une catégorie (si vous voulez ajouter une fonctionnalité pour cela)
    #[Route('/category/copy/{id}', name: 'category_copy')]
    public function copy(Category $category, EntityManagerInterface $entityManager): Response
    {
        $newCategory = clone $category; // Créer une copie de la catégorie
        $entityManager->persist($newCategory);
        $entityManager->flush();

        $this->addFlash('success', 'Category copied successfully');

        return $this->redirectToRoute('category_list');
    }
}