<?php
/**
 * Created by PhpStorm.
 * User: gbtux
 * Date: 29/11/17
 * Time: 19:34
 */

namespace App\EventSubscriber;


use \Hashids\Hashids;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\PreDeserializeEvent;
use JMS\Serializer\EventDispatcher\PreSerializeEvent;

class HashSuscriber implements EventSubscriberInterface
{
    /**
     * @var Hashids
     */
    private $hashids;

    public function __construct(Hashids $hashids)
    {
        $this->hashids = $hashids;
    }


    public static function getSubscribedEvents()
    {
        return [
            [
                'event' => 'serializer.pre_serialize',
                'method' => 'onPreSerializeData',
                'class' => 'App\Entity\DevisArticle'
            ],
            [
                'event' => 'serializer.pre_serialize',
                'method' => 'onPreSerializeData',
                'class' => 'App\Entity\DevisPoste'
            ],
            [
                'event' => 'serializer.pre_serialize',
                'method' => 'onPreSerializeData',
                'class' => 'App\Entity\DevisSousPoste'
            ],
            [
                'event' => 'serializer.pre_serialize',
                'method' => 'onPreSerializeData',
                'class' => 'App\Entity\Estimation'
            ],
            [
                'event' => 'serializer.pre_serialize',
                'method' => 'onPreSerializeData',
                'class' => 'App\Entity\Personnel'
            ],
            [
                'event' => 'serializer.pre_serialize',
                'method' => 'onPreSerializeData',
                'class' => 'App\Entity\PersonnelSpecialite'
            ],
            [
                'event' => 'serializer.pre_serialize',
                'method' => 'onPreSerializeData',
                'class' => 'App\Entity\EventTask'
            ],
            [
                'event' => 'serializer.pre_serialize',
                'method' => 'onPreSerializeData',
                'class' => 'App\Entity\Achat'
            ],
            [
                'event' => 'serializer.pre_serialize',
                'method' => 'onPreSerializeData',
                'class' => 'App\Entity\AchatCategorie'
            ],
            [
                'event' => 'serializer.pre_serialize',
                'method' => 'onPreSerializeData',
                'class' => 'App\Entity\Fournisseur'
            ],
            [
                'event' => 'serializer.pre_serialize',
                'method' => 'onPreSerializeData',
                'class' => 'App\Entity\Contact'
            ],
            [
                'event' => 'serializer.pre_serialize',
                'method' => 'onPreSerializeData',
                'class' => 'App\Entity\BordereauLivraison'
            ],
            [
                'event' => 'serializer.pre_serialize',
                'method' => 'onPreSerializeData',
                'class' => 'App\Entity\Chantier'
            ]
        ];
    }

    public function onPreSerializeData(PreSerializeEvent $event)
    {
        $object = $event->getObject();
        $object->setHashedId($this->hashids->encode($object->getId()));
    }

}