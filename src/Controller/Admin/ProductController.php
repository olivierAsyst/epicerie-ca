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

    #[Route('/{id}', 'update', methods: ['GET', 'POST'], requirements: ['id'=>Requirement::DIGITS])]
    public function update(Request $request, EntityManagerInterface $em, Product $product): Response
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
        return $this->render('admin/product/edit.html.twig',[
            'product' => $product,
            'form'=> $form
        ]);
    }

    #[Route('/{id}/delete', name: 'delete', methods: ['DELETE'], requirements: ['id'=> Requirement::DIGITS])]
    public function delete(Product $product, EntityManagerInterface $em)
    {
        $em->remove($product);
        $em->flush();
        $this->addFlash('success','La produit a été bien supprimé');
        return $this->redirectToRoute('admin.product.index');
    }

    public function makeSlug($name): string
    {
        return str_replace(' ', '-', strtolower($name));
    }
}
