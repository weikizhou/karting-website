<?php


namespace App\Controller;


use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\CategoryRepository;
use App\Repository\MomentRepository;
use App\Repository\PageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;


class DefaultController extends AbstractController
{

    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @Route("/api/home", name="index")
     */
    public function index(PageRepository $pageRepository, Request $request)
    {
        $pages = $pageRepository->findAll();
        $currentPage = $pageRepository->findOneBy(['slug'=> 'home']);
        $sections = $currentPage->getSection()->getValues();
        $data = [
            'pages' => $pages,
            'currentPage' => $currentPage,
            'sections' => $sections,
        ];
        $jsonContent = $this->serializer->serialize($data,JsonEncoder::FORMAT, []);

        echo $jsonContent;
        return new JsonResponse($jsonContent, Response::HTTP_OK, [], true);

//        return $this->render('frontend/index.twig', [
//            'title' => $currentPage->getNavTitle().' | Kartcentrum Max',
//            'currentPage' => $currentPage,
//            'sections' => $sections,
//            'pages' => $pages,
//        ]);
    }

    /**
     * @Route("/{slug}", name="page")
     */
    public function page(PageRepository $pageRepository, CategoryRepository $categoryRepository,
                         MomentRepository $momentRepository, $slug)
    {
        if ($slug == "login"){
            return $this->redirectToRoute('app_login');
        }
        $pages = $pageRepository->findAll();
        $currentPage = $pageRepository->findOneBy(['slug'=> $slug]);

        $sections = $currentPage->getSection()->getValues();
        $category = $categoryRepository->findAll();
        foreach ($category as $c) {
            $introduction = preg_replace("/<\/?div[^>]*\>/i", "", $c->getIntroduction());
            $c->setIntroduction($introduction);
        }

        $moments = $momentRepository->FilterDate($momentRepository->findAll());
        if (empty($moments)){
            $moments = [];
        }

        return $this->render('frontend/index.twig', [
            'title' => $currentPage->getNavTitle().' | Kartcentrum Max',
            'currentPage' => $currentPage,
            'sections' => $sections,
            'category' => $category,
            'moments' => $moments,
            'pages' => $pages,
        ]);
    }

    /**
     * @Route("/categorie/{slug}", name="category-detail")
     */
    public function categoryDetail(PageRepository $pageRepository, CategoryRepository $categoryRepository, $slug)
    {
        $pages = $pageRepository->findAll();

        $category = $categoryRepository->findOneBy(['slug' => $slug]);
        $introduction = preg_replace("/<\/?div[^>]*\>/i", "", $category->getIntroduction());
        $category->setIntroduction($introduction);

        $carousel = $category->getCarousel()->getValues();
        if (empty($carousel)){
            $carousel = [];
        }

        return $this->render('frontend/category-detail.twig', [
            'title' => $category->getName() . ' | Kartcentrum Max',
            'category' => $category,
            'carousel' => $carousel,
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
        return $this->redirectToRoute('index');
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

//            $dateOfBirth =  $form->get('date_of_birth')->getData();

            $user->setPassword($passwordEncode);
            $user->setOldPassword($passwordEncode);
            $user->setRepeatedPassword($passwordRepeatedEncode);
            $user->setRoles(['ROLE_USER']);

            $em->persist($user);
            $em->flush($user);

            return $this->redirectToRoute('app_login');
        }

        return $this->render('frontend/registration.twig', [
            'title' => 'Registratie | Kartcentrum Max',
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

