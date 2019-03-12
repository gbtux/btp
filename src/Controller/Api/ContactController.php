<?php

namespace App\Controller\Api;

use App\Entity\Contact;
use App\Form\ContactType;
use Hashids\Hashids;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ContactController
 * @package App\Controller\Api
 * @Rest\Route("/api/contacts")
 */
class ContactController extends AbstractController
{

    /**
     * @Rest\Get("/{hashedId}/chantiers")
     * @Rest\View(serializerGroups={"simple"})
     */
    public function getChantiers($hashedId, Hashids $hashids)
    {
        $id = $hashids->decode($hashedId);
        $contact = $this->getDoctrine()->getRepository('App:Contact')->findOneBy(['id' => $id]);
        if(!$contact)
            throw new NotFoundHttpException('Contact not found');
        return $contact->getChantiers();
    }

    /**
     * @param Request $request
     * @param $hashedId
     * @param Hashids $hashids
     * @return Contact|null|object|Response
     * @Rest\Put("/{hashedId}")
     * @Rest\View(serializerGroups={"simple"})
     */
    public function update(Request $request, $hashedId, Hashids $hashids)
    {
        $id = $hashids->decode($hashedId);
        $contact = $this->getDoctrine()->getRepository('App:Contact')->findOneBy(['id' => $id]);
        if(!$contact)
            throw new NotFoundHttpException('Contact not found');
        $form = $this->createForm(ContactType::class, $contact);
        $form->submit($request->request->all());
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();
            return $contact;
        }
        return new Response((string) $form->getErrors(true, false), 500);
    }

    /**
     * @Rest\Get("/{hashedId}")
     * @Rest\View(serializerGroups={"simple"})
     */
    public function getContact($hashedId, Hashids $hashids)
    {
        $id = $hashids->decode($hashedId);
        $contact = $this->getDoctrine()->getRepository('App:Contact')->findOneBy(['id' => $id]);
        if(!$contact)
            throw new NotFoundHttpException('Contact not found');
        return $contact;
    }

    /**
     * @Rest\Get("")
     * @Rest\View(serializerGroups={"simple"})
     */
    public function liste()
    {
        $contacts = $this->getDoctrine()->getRepository('App:Contact')->findAll();
        return $contacts;
    }

    /**
     * @param Request $request
     * @return Contact|Response
     * @Rest\Post("")
     * @Rest\View(serializerGroups={"simple"})
     */
    public function create(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->submit($request->request->all());
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();
            return $contact;
        }
        return new Response((string) $form->getErrors(true, false), 500);
    }
}
