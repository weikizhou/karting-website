<?php


namespace App\Controller;


use App\Entity\Registration;
use App\Form\ResetPasswordType;
use App\Form\UserType;
use App\Repository\CategoryRepository;
use App\Repository\MomentRepository;
use App\Repository\PageRepository;
use App\Repository\RegistrationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/gebruiker/kartcentrum", name="user")
     */
    public function userIndex(PageRepository $pageRepository, MomentRepository $momentRepository)
    {
        $pages = $pageRepository->findAll();
        $moments = $momentRepository->FilterDate($momentRepository->findAll());

        foreach ($moments as $moment) {
            $introduction = preg_replace("/<\/?div[^>]*\>/i", "", $moment->getCategory()->getIntroduction());
            $moment->getCategory()->setIntroduction($introduction);
        }

        return $this->render('user/index.twig', [
            'title' => 'Gebruiker | Kartcentrum Max',
            'moments' => $moments,
            'pages' => $pages,
        ]);
    }

    /**
     * @Route("/gebruiker/gegevens", name="user-detail")
     */
    public function userDetail(PageRepository $pageRepository, Request $request, EntityManagerInterface $em)
    {
        $pages = $pageRepository->findAll();
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $em->persist($user);
            $em->flush($user);

            return $this->redirectToRoute('user-detail');
        }

        return $this->render('user/detail.twig', [
            'title' => 'Gebruiker | Kartcentrum Max',
            'user' => $user,
            'userForm' => $form->createView(),
            'pages' => $pages,
        ]);
    }

    /**
     * @Route("/gebruiker/wachtwoord/wijzigen", name="reset-password")
     */
    public function resetPassword(PageRepository $pageRepository, Request $request, UserPasswordEncoderInterface $encoder, EntityManagerInterface $em)
    {
        $pages = $pageRepository->findAll();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $oldPassword = $user->getOldPassword();

        $form = $this->createForm(ResetPasswordType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            if ($oldPassword != $user->getPassword()){
                $passwordEncode = $encoder->encodePassword($user,  $user->getPassword());
                $passwordRepeatedEncode = $encoder->encodePassword($user,  $user->getRepeatedPassword());
                $oldPasswordEncode = $encoder->encodePassword($user,  $user->getOldPassword());
                if ($user->getPassword() == $user->getRepeatedPassword()){
                    $user->setPassword($passwordEncode);
                    $user->setRepeatedPassword($passwordRepeatedEncode);
                    $user->setOldPassword($oldPasswordEncode);

                    $this->addFlash(
                        'success',
                        'Uw wachtwoord is gewijzigd.'
                    );
                }
                else{
                    $this->addFlash(
                        'danger',
                        'Uw wachtwoord en herhaalde wachtwoord is niet identiek.'
                    );
                }
            }
            else{
                $this->addFlash(
                    'warning',
                    'Uw oude wachtwoord is hetzelfde als uw nieuwe wachtwoord.'
                );
            }
            $em->persist($user);
            $em->flush($user);

            return $this->redirectToRoute('reset-password');
        }

        return $this->render('user/reset-password.twig', [
            'title' => 'Gebruiker | Kartcentrum Max',
            'user' => $user,
            'userForm' => $form->createView(),
            'pages' => $pages,
        ]);
    }

    /**
     * @Route("/gebruiker/kartcentrum/{slug}/{date}", name="moment-detail")
     */
    public function momentDetail(PageRepository $pageRepository, MomentRepository $momentRepository,
                               CategoryRepository $categoryRepository, RegistrationRepository  $registrationRepository,
                               $slug, $date)
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

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $registration = $registrationRepository->findBy(['user' => $user, 'moment' => $lesson[0]]);
        if(empty($registration)){
            $registration = [];
        }
        $currentRegistrations = $registrationRepository->findBy(['moment' => $lesson]);
        $availablePlaces = $lesson[0]->getMaxParticipants() - count($currentRegistrations);
        if ($lesson[0]->getMaxParticipants() <= count($currentRegistrations)){
            $registrationFull = true;
        }
        else{
            $registrationFull = false;
        }
        if (empty($availablePlaces)){
            $availablePlaces = [];
        }

        $carousel = $category->getCarousel()->getValues();
        if (empty($carousel)){
            $carousel = [];
        }

        $introduction = preg_replace("/<\/?div[^>]*\>/i", "", $lesson[0]->getCategory()->getIntroduction());
        $lesson[0]->getCategory()->setIntroduction($introduction);

        return $this->render('user/moment-detail.twig', [
            'title' => $lesson[0]->getCategory()->getName() .' | Kartcentrum Max',
            'lesson' => $lesson,
            'registration' => $registration,
            'registrationFull' => $registrationFull,
            'availablePlaces' => $availablePlaces,
            'carousel' => $carousel,
            'pages' => $pages,
        ]);
    }

    /**
     * @Route("/gebruiker/kartcentrum/register-activity/{slug}/{date}", name="register-activity")
     */
    public function registerActivity(PageRepository $pageRepository, MomentRepository $momentRepository,
                                     CategoryRepository $categoryRepository, RegistrationRepository $registrationRepository,
                                     $slug, $date, EntityManagerInterface $em)
    {
        $pages = $pageRepository->findAll();

        $newDate = \DateTime::createFromFormat('d-m-Y', $date);
        $category = $categoryRepository->findOneBy(['slug' => $slug]);
        $lesson = $momentRepository->getCurrentLesson($category, $newDate->setTime(0,0,00));

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $birthDate = $user->getDateOfBirth();
        $now = new \DateTime();
        $age = $now->diff($birthDate)->y;

        $currentRegistrations = $registrationRepository->findBy(['moment' => $lesson]);
        if (count($currentRegistrations) < $lesson[0]->getMaxParticipants()){
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
                        'U bent ingeschreven in de '. strtolower($lesson[0]->getCategory()->getName()) . '.'
                    );

                    return $this->redirectToRoute('moment-detail', ['slug'=>$slug, 'date'=>$date]);
                }
            }
            else{
                $this->addFlash(
                    'warning',
                    'U moet ' .$lesson[0]->getCategory()->getMinimumAge(). ' jaar zijn om hieraan deel te nemen.'
                );
                return $this->redirectToRoute('moment-detail', ['slug'=>$slug, 'date'=>$date]);
            }
        }
        else{
            $this->addFlash(
                'warning',
                'De '.strtolower($lesson[0]->getCategory()->getName()). ' zit vol!'
            );
            return $this->redirectToRoute('moment-detail', ['slug'=>$slug, 'date'=>$date]);
        }

        return $this->render('user/moment-detail.twig', [
            'title' => 'Gebruiker | Kartcentrum Max',
            'lesson' => $lesson,
            'pages' => $pages,
        ]);
    }

    /**
     * @Route("/gebruiker/kartcentrum/verwijder/{slug}/{date}", name="delete-register")
     */
    public function deleteRegister(MomentRepository $momentRepository,
                               CategoryRepository $categoryRepository, RegistrationRepository  $registrationRepository,
                               EntityManagerInterface  $em, $slug, $date)
    {
        $newDate = \DateTime::createFromFormat('d-m-Y', $date);
        $category = $categoryRepository->findOneBy(['slug' => $slug]);
        if ($newDate < new \DateTime()){
            return $this->redirectToRoute('empty-lesson', ['slug'=>$slug, 'date' => $date]);
        }
        $lesson = $momentRepository->getCurrentLesson($category, $newDate->setTime(0,0,00));
        if(empty($lesson)){
            return $this->redirectToRoute('empty-lesson', ['slug'=>$slug, 'date' => $date]);
        }
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $registration = $registrationRepository->findOneBy(['moment' => $lesson, 'user' => $user]);
        if ($registration != null){
            $em->remove($registration);
            $em->flush();

            $this->addFlash(
                'danger',
                'U bent uitgeschreven uit de ' .strtolower($lesson[0]->getCategory()->getName()). '.'
            );
            return $this->redirectToRoute('moment-detail', ['slug' => $slug, 'date' => $date]);
        }
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