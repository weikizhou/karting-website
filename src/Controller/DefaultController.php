<?php


namespace App\Controller;


use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(PageRepository $pageRepository)
    {
        $pages = $pageRepository->findAll();
        $currentPage = $pageRepository->findOneBy(['slug'=> 'home']);
        $sections = $currentPage->getSection()->getValues();

        return $this->render('frontend/index.twig', [
            'title' => $currentPage->getNavTitle().' | Karting Max',
            'currentPage' => $currentPage,
            'sections' => $sections,
            'pages' => $pages,
        ]);
    }
}

