<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route("/admin/category", "admin.category.")]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('admin/category/index.html.twig',[
            'categories'=> $categories
        ]);
    }

    #[Route('/create', 'create')]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (empty($data)) return new JsonResponse(['error' => 'Le nom est requis']);

        $category = new Category();
        $category->setName( $data['name']);
        $category->setSlug($this->makeSlug($data['name']));
        $category->setCreatedAt(new \DateTimeImmutable);

        $em->persist($category);
        $em->flush();

        return new JsonResponse([
            'message' => 'La categorie ave ete ajouté',
            'category' => [
                'id'=> $category->getId(),
                'name'=> $category->getName(),
            ],
        ]);

    }

    public function makeSlug($name): string
    {
        return str_replace(' ', '-', strtolower($name));
    }
}
