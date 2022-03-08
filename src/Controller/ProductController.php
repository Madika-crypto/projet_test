<?php
namespace App\Controller;

use App\Entity\Product;
use App\Entity\Category;
use App\Form\ProductType;
use App\Service\UploadService;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/product')]
class ProductController extends AbstractController
{
    // #[Route('/{id}/delete', name: 'product_index', methods: ['GET'])]
    #[Route('/{category}', name: 'product_index', defaults:['category' =>0], methods: ['GET'])]
    // public function index(ProductRepository $productRepository): Response
    public function index(?Category $category, ProductRepository $productRepository): Response
    {
        if (!$category) {
            $products = $productRepository->findAll();
        } else {
            $productCriteria = [
                'category' => $category,
            ];
            $products = $productRepository->findBy($productCriteria);
        }
      
        // dd($products);

        return $this->render('product/index.html.twig', [
            // 'products' => $productRepository->findAll(),
            'products' => $products,
        ]);
    }

    #[Route('/new', name: 'product_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UploadService $uploadService): Response
    // public function new(Request $request, EntityManagerInterface $entityManager, UploadedService $uploadedService): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $file = $uploadService->upload($imageFile);
                $product->setImage($file);
            }
            
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{product}/show', name: 'product_show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/{id}/edit', name: 'product_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    public function edit(Request $request, Product $product, EntityManagerInterface $entityManager, UploadService $uploadService): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('image')->getData();
            
            if ($imageFile) {
                $oldFile = $product->getImage();
                $file = $uploadService->upload($imageFile, $oldFile);
                $product->setImage($file);
                }
            $entityManager->flush();

            return $this->redirectToRoute('product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'product_delete', methods: ['POST'])]
    public function delete(Request $request, Product $product, EntityManagerInterface $entityManager, UploadService $uploadService): Response
    // public function delete(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->request->get('_token'))) {
            $uploadService->delete($product->getImage());
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('product_index', [], Response::HTTP_SEE_OTHER);
    }
}
