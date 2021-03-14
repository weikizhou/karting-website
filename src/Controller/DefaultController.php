<?php


namespace App\Controller;


use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\PageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
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
    public function page(PageRepository $pageRepository, $slug)
    {
        if ($slug == "login"){
            return $this->redirectToRoute('app_login');
        }
        $pages = $pageRepository->findAll();
        $currentPage = $pageRepository->findOneBy(['slug'=> $slug]);

        $sections = $currentPage->getSection()->getValues();

        return $this->render('frontend/index.twig', [
            'title' => $currentPage->getNavTitle().' | Karting Max',
            'currentPage' => $currentPage,
            'sections' => $sections,
            'pages' => $pages,
        ]);
    }

    /**
     * @Route("/login/kartcentrum", name="app_login")
     */
    public function login(PageRepository $pageRepository, AuthenticationUtils $authenticationUtils)
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
     * @Route("/logout/kartcentrum", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/registratie/kartcentrum", name="registration")
     */
    public function registration(PageRepository $pageRepository, Request $request, EntityManagerInterface $em,
                                 UserPasswordEncoderInterface $encoder)
    {
        $pages = $pageRepository->findAll();

        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();

            $passwordEncode = $encoder->encodePassword($user,  $user->getPassword());
            $passwordRepeatedEncode = $encoder->encodePassword($user,  $user->getRepeatedPassword());

            $user->setPassword($passwordEncode);
            $user->setRepeatedPassword($passwordRepeatedEncode);
            $user->setRoles(['ROLE_USER']);

            $em->persist($user);
            $em->flush($user);

            return $this->redirectToRoute('registration');
        }

        return $this->render('frontend/registration.twig', [
            'title' => 'Registratie | Karting Max',
            'registrationForm' => $form->createView(),
            'pages' => $pages,
        ]);
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

