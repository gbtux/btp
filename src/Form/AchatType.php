<?php

namespace App\Form;

use App\Entity\Achat;
use App\Entity\Fournisseur;
use Hashids\Hashids;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AchatType extends AbstractType
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
            ->add('libelle')
            ->add('totalHT')
            ->add('totalTTC')
            ->add('totalTVA55')
            ->add('totalTVA10')
            ->add('totalTVA20')
            ->add('frais')
            ->add('isPaid')
            ->add('datePaiement', DateTimeType::class, ['widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'required' => false])
            ->add('dateDepense', DateTimeType::class, ['widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'required' => true])
            ->add('modePaiement')
            ->add('document')
            ->add('cancelled')
            ->add('category')
            ->add('fournisseur', EntityType::class, [
                'choice_label' => 'raisonSociale',
                'class' => Fournisseur::class,
                'choice_value' => function(Fournisseur $fournisseur = null) {
                    return $fournisseur ? $this->hashids->encode($fournisseur->getId()) : null;
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Achat::class,
            'csrf_protection' => false
        ]);
    }
}
