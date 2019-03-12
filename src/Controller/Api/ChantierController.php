<?php

namespace App\Controller\Api;

use App\Entity\Chantier;
use App\Form\ChantierType;
use Hashids\Hashids;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ChantierController
 * @package App\Controller\Api
 * @Rest\Route("/api/chantiers")
 */
class ChantierController extends AbstractController
{
    /**
     * @Rest\Get("")
     * @Rest\View(serializerGroups={"simple"})
     */
    public function liste()
    {
        $chantiers = $this->getDoctrine()->getRepository('App:Chantier')->findAll();
        return $chantiers;
    }

    /**
     * @param Request $request
     * @return Chantier|Response
     * @Rest\Post("")
     * @Rest\View(serializerGroups={"simple"})
     */
    public function create(Request $request)
    {
        $contact = new Chantier();
        $form = $this->createForm(ChantierType::class, $contact);
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
     * @param Request $request
     * @param $hashedId
     * @param Hashids $hashids
     * @return Chantier|null|object|Response
     * @Rest\Put("/{hashedId}")
     * @Rest\View(serializerGroups={"simple"})
     */
    public function update(Request $request, $hashedId, Hashids $hashids)
    {
        $id = $hashids->decode($hashedId);
        $chantier = $this->getDoctrine()->getRepository('App:Chantier')->findOneBy(['id' => $id]);
        if(!$chantier)
            throw new NotFoundHttpException('Chantier not found');
        $form = $this->createForm(ChantierType::class, $chantier);
        $form->submit($request->request->all());
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($chantier);
            $em->flush();
            return $chantier;
        }
        return new Response((string) $form->getErrors(true, false), 500);
    }

    /**
     * @Rest\Get("/{hashedId}")
     * @Rest\View(serializerGroups={"simple"})
     */
    public function getChantier($hashedId, Hashids $hashids)
    {
        $id = $hashids->decode($hashedId);
        $chantier = $this->getDoctrine()->getRepository('App:Chantier')->findOneBy(['id' => $id]);
        if(!$chantier)
            throw new NotFoundHttpException('Chantier not found');
        return $chantier;
    }
}
