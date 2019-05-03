<?php

namespace App\Controller\Api;

use App\Entity\Personnel;
use App\Form\PersonnelType;
use Hashids\Hashids;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class PersonnelController
 * @package App\Controller\Api
 * @Rest\Route("/api/personnels")
 */
class PersonnelController extends AbstractController
{
    /**
     * @Rest\Get("/specialites")
     * @Rest\View(serializerGroups={"simple"})
     */
    public function getSpecialites()
    {
        $specialites = $this->getDoctrine()->getRepository('App:PersonnelSpecialite')->findAll();
        return $specialites;
    }
    /**
     * @Rest\Get("")
     * @Rest\View(serializerGroups={"simple"})
     */
    public function liste()
    {
       $personnels = $this->getDoctrine()->getRepository('App:Personnel')->findAll();
       return $personnels;
    }

    /**
     * @param $hashedId
     * @param Hashids $hashids
     * @Rest\Get("/{hashedId}")
     * @Rest\View(serializerGroups={"simple"})
     */
    public function getPersonnel($hashedId, Hashids $hashids)
    {
        $id = $hashids->decode($hashedId);
        $personnel = $this->getDoctrine()->getRepository('App:Personnel')->findOneBy(['id'=>$id]);
        if(!$personnel)
            throw new NotFoundHttpException('Personnel not found');
        return $personnel;
    }

    /**
     * @param Request $request
     * @param $hashedId
     * @param Hashids $hashids
     * @return object|Response|null
     * @Rest\Put("/{hashedId}")
     * @Rest\View(serializerGroups={"simple"})
     */
    public function update(Request $request, $hashedId, Hashids $hashids)
    {
        $id = $hashids->decode($hashedId);
        $personnel = $this->getDoctrine()->getRepository('App:Personnel')->findOneBy(['id'=>$id]);
        if(!$personnel)
            throw new NotFoundHttpException('Personnel not found');
        $form = $this->createForm(PersonnelType::class, $personnel);
        $form->submit($request->request->all());
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($personnel);
            $em->flush();
            return $personnel;
        }
        return new Response((string) $form->getErrors(true, false), 500);
    }

    /**
     * @param Request $request
     * @Rest\Post("")
     * @Rest\View(serializerGroups={"simple"})
     */
    public function create(Request $request)
    {
        $personnel = new Personnel();
        $form = $this->createForm(PersonnelType::class, $personnel);
        $form->submit($request->request->all());
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($personnel);
            $em->flush();
            return $personnel;
        }
        return new Response((string) $form->getErrors(true, false), 500);
    }
}
