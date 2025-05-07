<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProductRepository;
use App\Entity\Product;
use App\Form\ProductType;
use App\Service\FileUploaderService;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class ProductController extends AbstractController
{
    #[Route('/products', name: 'product_index')]
    public function index(ProductRepository $repository) : Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $repository->findAll(),
        ]);
    }

    #[Route('/product/{id<\d+>}', name: 'product_show')]
    public function show(Product $product) : Response
    {
        // $product = $repository->find($id);

        // if ($product === null)
        // {
        //     throw $this->createNotFoundException('Product not found!');
        // }

        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
    }

    #[Route('/product/new', name: 'product_new')]
    public function new(Request $request, EntityManagerInterface $manager, FileUploaderService $fileUploader) : Response 
    {
        $product = new Product;

        // Create a form for the Product entity using the ProductType form class
        $form = $this->createForm(ProductType::class, $product);

        // Processes the form submission and binds the request data to the $product entity
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {            
            $brochureFile = null;
            if ($form->has('brochure')) {
                $brochureFile = $form->get('brochure')->getData();
            }
            if ($brochureFile) {
                $brochureFileName = $fileUploader->upload($brochureFile);
                $product->setBrochureFilename($brochureFileName);
            }
            
            $manager->persist($product);
 
            $manager->flush();

            $this->addFlash(
                'notice',
                'Product Saved sucessfully!'
            );

            return $this->redirectToRoute('product_show', [
                'id' => $product->getId(),
            ]);
        }

        return $this->render('product/new.html.twig', [
         'form' => $form],);
    }

    #[Route('/product/{id<\d+>}/edit', name: 'product_edit')]
    public function edit(Product $product, Request $request, EntityManagerInterface $manager, FileUploaderService $fileUploader): Response 
    {
                
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $brochureFile = $form->get('brochure')->getData();
            if ($brochureFile) {
                $brochureFileName = $fileUploader->upload($brochureFile);
                $product->setBrochureFileName($brochureFileName);
            }
            
            $manager->flush();

            $this->addFlash(
                'notice',
                'Product updated sucessfully!'
            );

            return $this->redirectToRoute('product_show', [
                'id' => $product->getId(),
            ]);
        }

        return $this->render('product/edit.html.twig', [
         'form' => $form],);
    }

    #[Route('/product/{id<\d+>}/delete', name: 'product_delete')]
    public function delete(Product $product, Request $request, EntityManagerInterface $manager): Response 
    {
        if ($request->isMethod('POST')) {

            $manager->remove($product);

            $manager->flush();

            $this->addFlash(
                'notice',
                'Product deleted successfully!'
            );

            return $this->redirectToRoute('product_index');

        }
        return $this->render('product/delete.html.twig', 
        [
            'id' => $product->getId(),
        ]);
    }

    #[Route('/product/show-macro', name: 'product_show_marco')]
    public function showMacroForm() : Response {
        return $this->render('product/show_macro.html.twig');
    }
}
