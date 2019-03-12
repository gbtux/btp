<?php

namespace App\Form;

use App\Entity\Chantier;
use App\Entity\Contact;
use Hashids\Hashids;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChantierType extends AbstractType
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
            ->add('libelle')
            ->add('adresse1')
            ->add('adresse2')
            ->add('codePostal')
            ->add('ville')
            ->add('tauxTVA')
            ->add('client', EntityType::class, [
                'choice_label' => 'nom',
                'class' => Contact::class,
                'choice_value' => function(Contact $contact = null) {
                    return $contact ? $this->hashids->encode($contact->getId()) : null;
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Chantier::class,
            'csrf_protection' => false
        ]);
    }
}
