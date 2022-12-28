<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, array("label" => "Email", 'attr' => array('class' => 'form-control form-control-user')))
            ->add('nom', TextType::class, array("label" => "Nom complet", 'attr' => array('class' => 'form-control form-control-user')))
            ->add('login', TextType::class, array("label" => "Nom d'utilisateur", 'attr' => array('class' => 'form-control form-control-user')))
            ->add('phone', TelType::class, array("label" => "Téléphone", 'attr' => array('class' => 'form-control form-control-user')))
            ->add('password', PasswordType::class, array("label" => "Mot de passe", 'attr' => array('class' => 'form-control form-control-user')));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
