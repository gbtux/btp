<?php

namespace App\Form;

use App\Entity\Personnel;
use App\Entity\PersonnelSpecialite;
use Hashids\Hashids;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonnelType extends AbstractType
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
            ->add('civilite')
            ->add('nom')
            ->add('prenom')
            ->add('coutHoraire')
            ->add('specialite', EntityType::class, [
                'choice_label' => 'label',
                'class' => PersonnelSpecialite::class,
                'choice_value' => function(PersonnelSpecialite $specialite = null) {
                    return $specialite ? $this->hashids->encode($specialite->getId()) : null;
                }
            ])
            ->add('telephone')
            ->add('adresse')
            ->add('codePostal')
            ->add('ville')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Personnel::class,
            'csrf_protection' => false
        ]);
    }
}
