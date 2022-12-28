<?php

namespace App\Form;

use App\Entity\Certification;
use App\Entity\SessionCertif;
use App\Entity\TypeCertif;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CertificationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle')
            ->add('typeCertif', EntityType::class, array("class" => TypeCertif::class, "choice_label" => "libelle", "label" => "Type de Certification"))
            ->add('sessionCertif', EntityType::class, array("class" => SessionCertif::class, "choice_label" => "libelle", "label" => "Session"));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Certification::class,
        ]);
    }
}
