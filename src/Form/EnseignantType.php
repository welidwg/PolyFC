<?php

namespace App\Form;

use App\Entity\Enseignant;
use App\Entity\User;
use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnseignantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('matricule', TextType::class)
            ->add('dateNaissance', DateType::class, array("label" => "Date de naissance", "attr" => array("class" => "mb-3"),  'years' => range(date('Y') - 25, date('Y') - 80)))
            ->add('sexe', ChoiceType::class, ['choices' => [
                'Homme' => "Homme",
                'Femme' => "Femme",
            ], "attr" => array("class" => "mb-3")])
            ->add('Addresse', TextType::class)
            ->add('cin', IntegerType::class)
            ->add('passeport', TextType::class)
            ->add('specialite', TextType::class)
            ->add('iduser',EntityType::class, array("class" => User::class, "choice_label" => "login", "label" => "Compte lié", "attr" => ['class' => "r"]));
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Enseignant::class,
        ]);
    }
}
