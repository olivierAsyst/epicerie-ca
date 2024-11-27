<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route("/admin/product", "admin.product.")]
class ProductController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll(); 
        return $this->render('admin/product/index.html.twig', [
            'products'=> $products
        ]);
    }

    #[Route('/create', 'create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $product->setSlug($this->makeSlug($product->getName()));
            $product->setCreatedAt(new \DateTimeImmutable());
            $em->persist($product);
            $em->flush();
            $this->addFlash('success','Le produit a été ajouté');
            return $this->redirectToRoute('admin.product.index');
        }

        return $this->render('admin/product/create.html.twig',[
            'form' => $form
        ]);
    }

    #[Route('/edit', 'update', methods: ['GET', 'POST'], requirements: ['id'=>Requirement::DIGITS])]
    public function update(Request $request, EntityManagerInterface $em, Product $product)
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $product->setSlug($this->makeSlug($product->getName()));
            $product->setUpdatedAt(new \DateTimeImmutable());

            $em->flush();
            $this->addFlash('success', 'Le produit a été bien modifié');
            return $this->redirectToRoute('admin.product.index');
        }
        // return $this->render('admin/product/index.html.twig',[
            // 'products' = $product;
            // 'form'=> $form
        // ]);
    }

    public function makeSlug($name): string
    {
        return str_replace(' ', '-', strtolower($name));
    }
}
