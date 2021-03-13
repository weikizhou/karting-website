<?php


namespace App\Controller;


use App\Entity\Registration;
use App\Repository\CategoryRepository;
use App\Repository\MomentRepository;
use App\Repository\PageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/gebruiker/kartcentrum", name="user")
     */
    public function userIndex(PageRepository $pageRepository, MomentRepository $momentRepository)
    {
        $pages = $pageRepository->findAll();
        $moments = $momentRepository->FilterDate($momentRepository->findAll());

        return $this->render('user/index.twig', [
            'title' => 'Gebruiker | Kartcentrum Max',
            'moments' => $moments,
            'pages' => $pages,
        ]);
    }

    /**
     * @Route("/gebruiker/kartcentrum/{slug}/{date}", name="user-detail")
     */
    public function userDetail(PageRepository $pageRepository, MomentRepository $momentRepository, CategoryRepository $categoryRepository, $slug, $date)
    {
        $pages = $pageRepository->findAll();

        $newDate = \DateTime::createFromFormat('d-m-Y', $date);
        $category = $categoryRepository->findOneBy(['slug' => $slug]);
        if ($newDate < new \DateTime()){
            return $this->redirectToRoute('empty-lesson', ['slug'=>$slug, 'date' => $date]);
        }
        $lesson = $momentRepository->getCurrentLesson($category, $newDate->setTime(0,0,00));
        if(empty($lesson)){
            return $this->redirectToRoute('empty-lesson', ['slug'=>$slug, 'date' => $date]);
        }

        return $this->render('user/register.twig', [
            'title' => $lesson[0]->getCategory()->getName() .' | Kartcentrum Max',
            'lesson' => $lesson,
            'pages' => $pages,
        ]);
    }

    /**
     * @Route("/gebruiker/kartcentrum/register-activity/{slug}/{date}", name="register-activity")
     */
    public function registerActivity(PageRepository $pageRepository, MomentRepository $momentRepository,
                                     CategoryRepository $categoryRepository, $slug, $date, EntityManagerInterface $em)
    {
        $pages = $pageRepository->findAll();

        $newDate = \DateTime::createFromFormat('d-m-Y', $date);
        $category = $categoryRepository->findOneBy(['slug' => $slug]);
        $lesson = $momentRepository->getCurrentLesson($category, $newDate->setTime(0,0,00));

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $birthDate = $user->getDateOfBirth();
        $now = new \DateTime();
        $age = $now->diff($birthDate)->y;
        if ($age >= $lesson[0]->getCategory()->getMinimumAge()){
            if ($lesson != null && $user != null){
                $registration = new Registration();
                $registration->setUser($user);
                $registration->setMoment($lesson[0]);
                $registration->setCreatedAt(new \DateTime());
                $em->persist($registration);
                $em->flush($registration);

                $this->addFlash(
                    'success',
                    'Het inschrijven is gelukt!'
                );

                return $this->redirectToRoute('user-detail', ['slug'=>$slug, 'date'=>$date]);
            }
        }
        else{
            $this->addFlash(
                'warning',
                'U bent niet oud genoeg voor deze race.'
            );

            return $this->redirectToRoute('user-detail', ['slug'=>$slug, 'date'=>$date]);
        }
        return $this->render('user/register.twig', [
            'title' => 'Gebruiker | Kartcentrum Max',
            'lesson' => $lesson,
            'pages' => $pages,
        ]);
    }

    /**
     * @Route("/gebruiker/kartcentrum/lesson-not-found/{slug}/{date}", name="empty-lesson")
     */
    public function emptyLesson(PageRepository $pageRepository, CategoryRepository $categoryRepository , $slug, $date)
    {
        $pages = $pageRepository->findAll();

        return $this->render('user/lesson-not-found.twig', [
            'title' => '404 | Kartcentrum Max',
            'date' => $date,
            'slug' => $slug,
            'pages' => $pages,
        ]);
    }
}