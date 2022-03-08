<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NavBarController extends AbstractController
{
    public function navBarCats(CategoryRepository $catRepo): Response
    {
        $categories = $catRepo->findAll();
        return $this->render('partial/_navBarCats.html.twig', [
            'categories' => $categories,
        ]);
    }
}