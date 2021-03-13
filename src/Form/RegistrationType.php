<?php


namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
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
            ->add('username', TextType::class,['attr'=>['placeholder'=>' Gebruikersnaam'], 'label' => false])
            ->add('password', PasswordType::class,['attr'=>['placeholder'=>' Wachtwoord'], 'label' => false])
            ->add('repeated_password', PasswordType::class,['attr'=>['placeholder'=>' Herhaal wachtwoord'], 'label' => false])
            ->add('name', TextType::class,['attr'=>['placeholder'=>' Volledige naam'], 'label' => false])
            ->add('email', EmailType::class,['attr'=>['placeholder'=>' E-mailadres'], 'label' => false])
            ->add('phone', TextType::class,['attr'=>['placeholder'=>' Telefoon'], 'label' => false])
            ->add('postal_code', TextType::class,['attr'=>['placeholder'=>' Postcode'], 'label' => false])
            ->add('house_nr', TextType::class,['attr'=>['placeholder'=>' Huis nr.'], 'label' => false])
            ->add('address', TextType::class,['attr'=>['placeholder'=>' Adres'], 'label' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}