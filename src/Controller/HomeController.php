<?php

namespace App\Controller;

use DateTime;
use App\Tool\DateTool;
use App\Entity\Category;
use Doctrine\ORM\EntityManager;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{

    // ** ancienne forme d'écriture
    // **@Route('/home)

    // ** Ci-dessous nouvelle ecriture 


    #[Route('/', name: 'home')]
    // public function index(): Response
    public function index(CategoryRepository $catRepo): Response
    {   
        // $user = $this->getUser();
        // dd($user);
        // $this->addFlash("success","vous avez un message en vert");
        $categories = $catRepo->findAll();
        return $this->render('home/index.html.twig', [ 
            'categories' => $categories,
        ]);
    }

    // #[Route('/page2', name: 'home_page2')]
    // #[Route('/page-autre/{age}', name: 'home_page2')]
    
    #[Route('/page-autre/{age}', name: 'home_page2', defaults:['age' =>0], requirements: ['age'=>"\d+"], methods:["GET"])]
    // public function page2(int $age,DateTime $objet): Response
    public function page2(int $age, DateTool $object ): Response
    {
        dd($object->getdate());
        return $this->render('home/page2.html.twig', [
            'controller_name' => 'HomeController',
            'ageAffichage' => $age,
        ]);
    }


#[Route('/jfdksq', name: 'home_new_cat')]

// public function newCat (EntityManagerInterface $em):Response

//     {
//         $category=new Category();
//         $category->setName("cours symphony");

//         // $objectManager = new ObjectManager();

//         $em->persist($category);
//         $em->flush();

//         dd($category);
//         return $this->render('home/index.html.twig', [
//             'controller_name' => 'HomeController',
//         ]);
//     }



#[Route('/jfdksq', name: 'home_new_cat')]

// public function newCat (CategoryRepository $categoryRepo):Response
public function newCat (CategoryRepository $categoryRepo, EntityManagerInterface $em):Response

    {

        // $catCriteria =[ 'id'=>3,];
        // $catagories = $categoryRepo->findAll();
        // dd($catagories);
        $categorie = $categoryRepo->find(2);

        // $categorie->setName("cours symfony debutant");

        // $em->flush();
        $em->remove($categorie);
        $em->flush();

        dd($categorie);

       
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}




