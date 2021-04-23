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
use ApiPlatform\Core\Api\IriConverterInterface;

class DefaultController extends AbstractController
{

    /**
     * @Route("/{vueRouting}",
     *     requirements={
     *     "vueRouting"="^(?!api|_(profiler|wdt)).*"
     *     },
     *     name="index")
     */
    public function index(SerializerInterface $serializer){
        return $this->render('base.html.twig',
        [
            'user' => $serializer->serialize($this->getUser(), 'jsonld')
        ]);
    }

    /**
     * @Route("/api/login", name="app_login")
     */
    public function login(IriConverterInterface $iriConverter)
    {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->json([
                'error' => 'Invalid login request: check that the Content-Type header is "application/json".'
            ], 400);
        }
        return new Response(null, 204, [
            'Location' => $iriConverter->getIriFromItem($this->getUser())
        ]);
    }

    /**
     * @Route("/api/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception('should not be reached');
        return $this->redirectToRoute('index');

    }

//    /**
//     * @Route("/api/registratie/gebruiker", name="registration_user")
//     *
//     */
//    public function registrationUser(Request $request, UserPasswordEncoderInterface $encoder, EntityManagerInterface $em)
//    {
//        $data = json_decode($request->getContent(), true);
//        $user = new User();
//        $form = $this->createForm(RegistrationType::class, $user);
//
//        $form->handleRequest($request);
//        $form->submit($data);
//
//        $user->setUser($this->findUserByUsername('weaverryan'));
//
//        $em = $this->getDoctrine()->getManager();
//        $em->persist($user);
//        $em->flush();
//
//        return new Response('It worked. Believe me - I\'m an API');
//
//    }



//    /**
//     * @Route("/{vueRouting}", name="page")
//     */
//    public function page(PageRepository $pageRepository, CategoryRepository $categoryRepository,
//                         MomentRepository $momentRepository)
//    {
//        if ($slug == "login"){
//            return $this->redirectToRoute('app_login');
//        }
//        return $this->render('base.html.twig');

//        $pages = $pageRepository->findAll();
//        $currentPage = $pageRepository->findOneBy(['slug'=> $slug]);
//
//        $sections = $currentPage->getSection()->getValues();
//        $category = $categoryRepository->findAll();
//        foreach ($category as $c) {
//            $introduction = preg_replace("/<\/?div[^>]*\>/i", "", $c->getIntroduction());
//            $c->setIntroduction($introduction);
//        }
//
//        $moments = $momentRepository->FilterDate($momentRepository->findAll());
//        if (empty($moments)){
//            $moments = [];
//        }
//
//        return $this->render('frontend/index.twig', [
//            'title' => $currentPage->getNavTitle().' | Kartcentrum Max',
//            'currentPage' => $currentPage,
//            'sections' => $sections,
//            'category' => $category,
//            'moments' => $moments,
//            'pages' => $pages,
//        ]);
//    }

//    /**
//     * @Route("/categorie/{slug}", name="category-detail")
//     */
//    public function categoryDetail(PageRepository $pageRepository, CategoryRepository $categoryRepository, $slug)
//    {
//        $pages = $pageRepository->findAll();
//
//        $category = $categoryRepository->findOneBy(['slug' => $slug]);
//        $introduction = preg_replace("/<\/?div[^>]*\>/i", "", $category->getIntroduction());
//        $category->setIntroduction($introduction);
//
//        $carousel = $category->getCarousel()->getValues();
//        if (empty($carousel)){
//            $carousel = [];
//        }
//
//        return $this->render('frontend/category-detail.twig', [
//            'title' => $category->getName() . ' | Kartcentrum Max',
//            'category' => $category,
//            'carousel' => $carousel,
//            'pages' => $pages,
//        ]);
//    }

//    /**
//     * @Route("/login/kartcentrum", name="app_login")
//     */
//    public function login(PageRepository $pageRepository, AuthenticationUtils $authenticationUtils)
//    {
//        $pages = $pageRepository->findAll();
//        $error = $authenticationUtils->getLastAuthenticationError();
//        $lastUsername = $authenticationUtils->getLastUsername();
//
//        return $this->render('frontend/login.twig', array(
//            'title' => 'Inloggen | Karting Max',
//            'last_username' => $lastUsername,
//            'error'         => $error,
//            'pages' => $pages,
//        ));
//    }
//
//    /**
//     * @Route("/logout/kartcentrum", name="app_logout")
//     */
//    public function logout()
//    {
//        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
//        return $this->redirectToRoute('index');
//    }
//
//    /**
//     * @Route("/registratie/kartcentrum", name="registration")
//     */
//    public function registration(PageRepository $pageRepository, Request $request, EntityManagerInterface $em,
//                                 UserPasswordEncoderInterface $encoder)
//    {
//        $pages = $pageRepository->findAll();
//
//        $user = new User();
//        $form = $this->createForm(RegistrationType::class, $user);
//
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
//
//            $user = $form->getData();
//
//            $passwordEncode = $encoder->encodePassword($user,  $user->getPassword());
//            $passwordRepeatedEncode = $encoder->encodePassword($user,  $user->getRepeatedPassword());
//
////            $dateOfBirth =  $form->get('date_of_birth')->getData();
//
//            $user->setPassword($passwordEncode);
//            $user->setOldPassword($passwordEncode);
//            $user->setRepeatedPassword($passwordRepeatedEncode);
//            $user->setRoles(['ROLE_USER']);
//
//            $em->persist($user);
//            $em->flush($user);
//
//            return $this->redirectToRoute('app_login');
//        }
//
//        return $this->render('frontend/registration.twig', [
//            'title' => 'Registratie | Kartcentrum Max',
//            'registrationForm' => $form->createView(),
//            'pages' => $pages,
//        ]);
//    }
//
//    /**
//     * @Route("/page/not/found", name="page-not-found")
//     */
//    public function pageNotFound(PageRepository $pageRepository)
//    {
//        $pages = $pageRepository->findAll();
//        return $this->render('frontend/page-not-found.twig', [
//            'title' => '404 | Karting Max',
//            'pages' => $pages,
//        ]);
//    }


}

