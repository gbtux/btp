<?php

namespace App\Controller\Api;

use App\Entity\Fournisseur;
use App\Form\FournisseurType;
use Hashids\Hashids;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class FournisseurController
 * @package App\Controller\Api
 * @Rest\Route("/api/fournisseurs")
 */
class FournisseurController extends AbstractController
{
    /**
     * @Rest\Get("/{hashedId}")
     * @Rest\View(serializerGroups={"simple"})
     */
    public function getFournisseur($hashedId, Hashids $hashids)
    {
        $id = $hashids->decode($hashedId);
        $fournisseur = $this->getDoctrine()->getRepository('App:Fournisseur')->findOneBy(['id'=>$id]);
        if(!$fournisseur)
            throw new NotFoundHttpException('Fournisseur not found');
        return $fournisseur;
    }

    /**
     * @param Request $request
     * @param $hashedId
     * @param Hashids $hashids
     * @Rest\Put("/{hashedId}")
     * @Rest\View(serializerGroups={"simple"})
     */
    public function update(Request $request, $hashedId, Hashids $hashids)
    {
        $id = $hashids->decode($hashedId);
        $fournisseur = $this->getDoctrine()->getRepository('App:Fournisseur')->findOneBy(['id'=>$id]);
        if(!$fournisseur)
            throw new NotFoundHttpException('Fournisseur not found');
        $form = $this->createForm(FournisseurType::class, $fournisseur);
        $form->submit($request->request->all());
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($fournisseur);
            $em->flush();
            return $fournisseur;
        }
        return new Response((string) $form->getErrors(true, false), 500);
    }

    /**
     * @Rest\Get("")
     * @Rest\View(serializerGroups={"simple"})
     */
    public function liste()
    {
        $fournisseurs = $this->getDoctrine()->getRepository('App:Fournisseur')->findAll();
        return $fournisseurs;
    }

    /**
     * @param Request $request
     * @throws \Exception
     * @Rest\Post("")
     * @Rest\View(serializerGroups={"simple"})
     */
    public function create(Request $request)
    {
        $fournisseur = new Fournisseur();
        $form = $this->createForm(FournisseurType::class, $fournisseur);
        $form->submit($request->request->all());
        if($form->isSubmitted() && $form->isValid()){
            $fournisseur->setDateCreation(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($fournisseur);
            $em->flush();
            return $fournisseur;
        }
        return new Response((string) $form->getErrors(true, false), 500);
    }
}
