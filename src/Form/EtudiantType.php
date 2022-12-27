<?php

namespace App\Form;

use App\Entity\Etudiant;
use App\Entity\Filiere;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('matricule', TextType::class, array("label" => "Votre matricule", "attr" => array("placeholder" => "Matricule", "class" => " mb-3 ")))
            ->add('sexe', ChoiceType::class, ['choices' => [
                'Homme' => "Homme",
                'Femme' => "Femme",
            ], "attr" => array("class" => "form-control form-select mb-3 col-md-6")])
            ->add('dateN', DateType::class, array(
                "label" => "Date de naissance", "attr" => array("class" => "mb-3"),  'years' => range(date('Y') - 18, date('Y') - 40)

            ))
            ->add('lieuNaissance', TextType::class, array("label" => "Lieu de naissance", "attr" => array("class" => "form-control mb-3")))
            ->add('cin', IntegerType::class, array("label" => "Cin", "attr" => array("class" => "form-control mb-3", "maxLength" => 8, "minLength" => 8)))
            ->add('passeport', IntegerType::class, array("label" => "Numéro passeport", "attr" => array("class" => "form-control mb-3"), "required" => false))
            ->add('telParent', IntegerType::class, array("label" => "Numéro du parent", "attr" => array("class" => "form-control mb-3")))
            ->add('emailParent', EmailType::class, array("label" => "Email du parent", "attr" => array("class" => "form-control mb-3")))
            ->add('etatCivil', ChoiceType::class, ['choices' => [
                'Célibataire' => "Célibataire",
                'Marié' => "Marié",
                'Divorsé' => "Divorsé",
            ], "attr" => array("class" => "form-control form-select mb-3")])
            ->add('filiere', EntityType::class, array("class" => Filiere::class, "choice_label" => "libelle", "label" => "Filiere", "attr" => ['class' => "form-control form-select form-control-user"]))
            ->add('submit', SubmitType::class, array("label" => "Terminer", "attr" => array("class" => "btn btn-primary mx-auto w-100")));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
        ]);
    }
}
