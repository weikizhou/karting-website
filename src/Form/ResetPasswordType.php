<?php


namespace App\Form;


use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('old_password', PasswordType::class,['attr'=>['placeholder'=>'Oude wachtwoord'], 'label' => false, 'required' => true])
            ->add('password', PasswordType::class,['attr'=>['placeholder'=>'Nieuw wachtwoord'], 'label' => false, 'required' => true])
            ->add('repeated_password', PasswordType::class,['attr'=>['placeholder'=>'Herhaal wachtwoord'], 'label' => false, 'required' => true])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}