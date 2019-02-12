<?php

namespace App\Form;

use App\Entity\DevisLigneCommentaires;
use App\Entity\DevisLigneSousPoste;
use Hashids\Hashids;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DevisLigneCommentairesType extends AbstractType
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
            ->add('texte')
            ->add('sousPoste', EntityType::class, [
                'choice_label' => 'titre',
                'class' => DevisLigneSousPoste::class,
                'choice_value' => function(DevisLigneSousPoste $sousPoste = null) {
                    return $sousPoste ? $this->hashids->encode($sousPoste->getId()) : null;
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DevisLigneCommentaires::class,
            'csrf_protection' => false
        ]);
    }
}
