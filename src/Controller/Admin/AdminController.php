<?php

namespace App\Controller\Admin;

use App\Entity\Carousel;
use App\Entity\Category;
use App\Entity\Moment;
use App\Entity\Page;
use App\Entity\Registration;
use App\Entity\Section;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class AdminController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(AdminUrlGenerator::class);
        return $this->redirect($routeBuilder->setController(PageCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Kartcentrum Max');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToCrud('Page', 'fas fa-book', Page::class),
            MenuItem::linkToCrud('Section', 'fas fa-cubes', Section::class),
            MenuItem::linkToCrud('Moment', 'far fa-clock', Moment::class),
            MenuItem::linkToCrud('Category', 'fas fa-clipboard-list', Category::class),
            MenuItem::linkToCrud('Carousel', 'far fa-images', Carousel::class),
            MenuItem::linkToCrud('Registration', 'far fa-address-book', Registration::class),
            MenuItem::linkToCrud('User', 'fas fa-users-cog', User::class),
        ];
    }
}
