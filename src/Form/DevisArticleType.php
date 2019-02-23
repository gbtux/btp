<?php

namespace App\Form;

use App\Entity\DevisArticle;
use App\Entity\DevisSousPoste;
use Hashids\Hashids;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DevisArticleType extends AbstractType
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
            ->add('reference', TextType::class, [
                'required' => false,
                'empty_data' => ''
            ])
            ->add('designation')
            ->add('quantite')
            ->add('pubHT')
            ->add('unitePrix')
            //->add('remise')
            //->add('typeRemise')
            ->add('tauxTVA')
            ->add('sousPoste', EntityType::class, [
                'choice_label' => 'titre',
                'class' => DevisSousPoste::class,
                'choice_value' => function(DevisSousPoste $sousPoste = null) {
                    return $sousPoste ? $this->hashids->encode($sousPoste->getId()) : null;
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DevisArticle::class,
            'csrf_protection' => false
        ]);
    }
}
