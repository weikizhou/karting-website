<?php


namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class,['attr'=>['placeholder'=>'Gebruikersnaam'], 'label' => false, 'required' => true])
            ->add('password', PasswordType::class,['attr'=>['placeholder'=>'Wachtwoord'], 'label' => false, 'required' => true])
            ->add('repeated_password', PasswordType::class,['attr'=>['placeholder'=>'Herhaal wachtwoord'], 'label' => false, 'required' => true])
            ->add('name', TextType::class,['attr'=>['placeholder'=>'Volledige naam'], 'label' => false, 'required' => true])
            ->add('email', EmailType::class,['attr'=>['placeholder'=>'E-mailadres'], 'label' => false, 'required' => true])
            ->add('phone', TextType::class,['attr'=>['placeholder'=>'Telefoon'], 'label' => false, 'required' => true])
            ->add('postal_code', TextType::class,['attr'=>['placeholder'=>'Postcode'], 'label' => false, 'required' => true])
            ->add('house_nr', TextType::class,['attr'=>['placeholder'=>'Huis nr.'], 'label' => false, 'required' => true])
            ->add('address', TextType::class,['attr'=>['placeholder'=>'Adres'], 'label' => false, 'required' => true])
            ->add('date_of_birth', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker', 'placeholder'=>'Geboorte datum'],
                'html5' => false,
                'label' => false,
                'required' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}