<?php


namespace App\Controller;


use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

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

    /**
     * @Route("/{slug}", name="page")
     */
    public function page(PageRepository $pageRepository, $slug, Request $request)
    {
        if ($slug == "inloggen/kartcentrum"){
            return $this->redirectToRoute('user_login');
        }
        $pages = $pageRepository->findAll();
        $currentPage = $pageRepository->findOneBy(['slug'=> $slug]);

        $routeName = $request->get('_route');
        if($currentPage == [] && $routeName != "admin" && $routeName != 'user_login' && $routeName != 'registration' && $routeName != 'user'){
            return $this->redirectToRoute('page-not-found');
        }

        $sections = $currentPage->getSection()->getValues();

        return $this->render('frontend/index.twig', [
            'title' => $currentPage->getNavTitle().' | Karting Max',
            'currentPage' => $currentPage,
            'sections' => $sections,
            'pages' => $pages,
        ]);
    }

    /**
     * @Route("/inloggen/kartcentrum", name="user_login")
     */
    public function userLogin(PageRepository $pageRepository, AuthenticationUtils $authenticationUtils)
    {
        $pages = $pageRepository->findAll();
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('frontend/login.twig', array(
            'title' => 'Inloggen | Karting Max',
            'last_username' => $lastUsername,
            'error'         => $error,
            'pages' => $pages,
        ));
    }

    /**
     * @Route("/registratie/kartcentrum", name="registration")
     */
    public function registration(PageRepository $pageRepository)
    {
        $pages = $pageRepository->findAll();

        return $this->render('frontend/registration.twig', [
            'title' => 'Registratie | Karting Max',
            'pages' => $pages,
        ]);
    }

    /**
     * @Route("/gebruiker/kartcentrum", name="user")
     */
    public function userInterface(PageRepository $pageRepository)
    {
        $pages = $pageRepository->findAll();

        return $this->render('user/index.twig', [
            'title' => 'Gebruiker | Karting Max',
            'pages' => $pages,
        ]);
    }

    /**
     * @Route("/login/kartcentrum", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('@EasyAdmin/page/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'page_title' => 'Karting Login',
            'username_label' => 'Your username',
            'password_label' => 'Your password',
            'csrf_token_intention' => 'authenticate',
        ]);
    }

    /**
     * @Route("/logout/kartcentrum", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/page/not/found", name="page-not-found")
     */
    public function pageNotFound(PageRepository $pageRepository)
    {
        $pages = $pageRepository->findAll();
        return $this->render('frontend/page-not-found.twig', [
            'title' => '404 | Karting Max',
            'pages' => $pages,
        ]);
    }


}

