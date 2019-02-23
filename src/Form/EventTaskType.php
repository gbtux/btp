<?php

namespace App\Form;

use App\Entity\DevisArticle;
use App\Entity\EventTask;
use App\Entity\Personnel;
use Hashids\Hashids;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventTaskType extends AbstractType
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
            ->add('dateDebut', DateTimeType::class, ['widget' => 'single_text', 'format' => 'dd/MM/yyyy HH:mm', 'required' => true])
            ->add('dateFin', DateTimeType::class, ['widget' => 'single_text', 'format' => 'dd/MM/yyyy HH:mm', 'required' => true])
            ->add('allDay')
            ->add('commentaire')
            ->add('resource', EntityType::class, [
                'choice_label' => 'designation',
                'class' => DevisArticle::class,
                'choice_value' => function(DevisArticle $article = null) {
                    return $article ? $this->hashids->encode($article->getId()) : null;
                }
            ])
            ->add('executants', EntityType::class, [
                'choice_label' => 'nom',
                'class' => Personnel::class,
                'choice_value' => function(Personnel $personnel = null) {
                    return $personnel ? $this->hashids->encode($personnel->getId()) : null;
                },
                'multiple' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EventTask::class,
            'csrf_protection' => false
        ]);
    }
}
