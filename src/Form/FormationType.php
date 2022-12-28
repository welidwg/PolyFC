<?php

namespace App\Form;

use App\Entity\Certification;
use App\Entity\Enseignant;
use App\Entity\Formation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelleFormation')
            ->add('certification', EntityType::class, array("class" => Certification::class, "choice_label" => "libelle", "label" => "Certification"))
            ->add('enseignant', EntityType::class, array("class" => Enseignant::class, "choice_label" => "iduser.nom", "label" => "Enseignant", "attr" => ['class' => "form-control form-select form-control-user"]));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}
