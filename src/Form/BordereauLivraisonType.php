<?php

namespace App\Form;

use App\Entity\BordereauLivraison;
use App\Entity\Chantier;
use App\Entity\Contact;
use App\Entity\Fournisseur;
use Hashids\Hashids;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BordereauLivraisonType extends AbstractType
{
    /**
     * @var Hashids
     */
    private $hashids;


    public function __construct(Hashids $hashids)
    {
        $this->hashids = $hashids;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reference')
            ->add('totalHT')
            ->add('totalTVA55')
            ->add('totalTVA10')
            ->add('totalTVA20')
            ->add('totalTTC')
            ->add('frais')
            ->add('dateLivraison', DateTimeType::class, ['widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'required' => true])
            ->add('document')
            ->add('fournisseur', EntityType::class, [
                'choice_label' => 'raisonSociale',
                'class' => Fournisseur::class,
                'choice_value' => function(Fournisseur $fournisseur = null) {
                    return $fournisseur ? $this->hashids->encode($fournisseur->getId()) : null;
                }
            ])
            ->add('client', EntityType::class, [
                'choice_label' => 'nom',
                'class' => Contact::class,
                'choice_value' => function(Contact $contact = null) {
                    return $contact ? $this->hashids->encode($contact->getId()) : null;
                }
            ])
            ->add('chantier', EntityType::class, [
                'choice_label' => 'libelle',
                'class' => Chantier::class,
                'choice_value' => function(Chantier $chantier = null) {
                    return $chantier ? $this->hashids->encode($chantier->getId()) : null;
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BordereauLivraison::class,
            'csrf_protection' => false
        ]);
    }
}
