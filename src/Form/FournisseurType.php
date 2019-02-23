<?php

namespace App\Form;

use App\Entity\Fournisseur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FournisseurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code')
            ->add('raisonSociale')
            ->add('formeJuridique')
            ->add('siret')
            ->add('siren')
            ->add('codeApe')
            ->add('tvaIntra')
            ->add('adresse1')
            ->add('adresse2')
            ->add('codePostal')
            ->add('ville')
            ->add('telephone')
            ->add('email')
            ->add('fax')
            ->add('notes')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Fournisseur::class,
            'csrf_protection' => false
        ]);
    }
}
