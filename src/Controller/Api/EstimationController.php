<?php

namespace App\Controller\Api;

use App\Entity\DevisLigneArticle;
use App\Entity\DevisLigneCommentaires;
use App\Entity\DevisLigneSousPoste;
use App\Entity\DevisPoste;
use App\Form\DevisLigneArticleType;
use App\Form\DevisLigneCommentairesType;
use App\Form\DevisPosteType;
use App\Form\DevisSousPosteType;
use Hashids\Hashids;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class EstimationController
 * @package App\Controller\Api
 * @Rest\Route("/api/estimations")
 */
class EstimationController extends AbstractController
{
    /**
     * @param Request $request
     * @param $hashedId
     * @param $posteId
     * @param Hashids $hashids
     * @return object|Response|null
     * @Rest\Post("/{hashedId}/poste/{posteId}/commentaire")
     * @Rest\View(serializerGroups={"simple","lignes"})
     */
    public function addCommentaire(Request $request, $hashedId, $posteId, Hashids $hashids)
    {
        $id = $hashids->decode($hashedId);
        $estimation = $this->getDoctrine()->getRepository('App:Estimation')->findOneBy(['id'=>$id]);
        if(!$estimation)
            throw new NotFoundHttpException('Estimation not found');
        $pid = $hashids->decode($posteId);
        $poste = $this->getDoctrine()->getRepository('App:DevisPoste')->findOneBy(['id'=>$pid]);
        if(!$poste)
            throw new NotFoundHttpException('Poste not found');
        $commentaire = new DevisLigneCommentaires();
        $commentaire->setPoste($poste);
        $commentaire->setOrdre(0);
        $form = $this->createForm(DevisLigneCommentairesType::class, $commentaire);
        $form->submit($request->request->all());
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($commentaire);
            $em->flush();

            $estimation = $this->getDoctrine()->getRepository('App:Estimation')->findOneBy(['id'=>$id]);
            return $estimation;
        }
        return new Response((string) $form->getErrors(true, false), 500);
    }

    /**
     * @param Request $request
     * @param $hashedId
     * @param $posteId
     * @param Hashids $hashids
     * @return object|Response|null
     * @Rest\Post("/{hashedId}/poste/{posteId}/article")
     * @Rest\View(serializerGroups={"simple","lignes"})
     */
    public function addArticle(Request $request, $hashedId, $posteId, Hashids $hashids)
    {
        $id = $hashids->decode($hashedId);
        $estimation = $this->getDoctrine()->getRepository('App:Estimation')->findOneBy(['id'=>$id]);
        if(!$estimation)
            throw new NotFoundHttpException('Estimation not found');
        $pid = $hashids->decode($posteId);
        $poste = $this->getDoctrine()->getRepository('App:DevisPoste')->findOneBy(['id'=>$pid]);
        if(!$poste)
            throw new NotFoundHttpException('Poste not found');

        $article = new DevisLigneArticle();
        $article->setOrdre(0);
        $form = $this->createForm(DevisLigneArticleType::class, $article);
        $form->submit($request->request->all());
        if($form->isSubmitted() && $form->isValid()){
            if(null === $article->getSousPoste()){
                $article->setPoste($poste);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            $estimation = $this->getDoctrine()->getRepository('App:Estimation')->findOneBy(['id'=>$id]);
            return $estimation;
        }
        return new Response((string) $form->getErrors(true, false), 500);
    }


    /**
     * @param $request
     * @param $hashedId : estimation
     * @param $posteId : poste
     * @Rest\Post("/{hashedId}/poste/{posteId}/sousPoste")
     * @Rest\View(serializerGroups={"simple","lignes"})
     */
    public function addSousPoste(Request $request, $hashedId, $posteId, Hashids $hashids)
    {
        $id = $hashids->decode($hashedId);
        $estimation = $this->getDoctrine()->getRepository('App:Estimation')->findOneBy(['id'=>$id]);
        if(!$estimation)
            throw new NotFoundHttpException('Estimation not found');
        $pid = $hashids->decode($posteId);
        $poste = $this->getDoctrine()->getRepository('App:DevisPoste')->findOneBy(['id'=>$pid]);
        if(!$poste)
            throw new NotFoundHttpException('Poste not found');
        $sousPoste = new DevisLigneSousPoste();
        $sousPoste->setPoste($poste);
        $sousPoste->setOrdre(0);
        $form = $this->createForm(DevisSousPosteType::class, $sousPoste);
        $form->submit($request->request->all());
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($sousPoste);
            $em->flush();
            return $sousPoste;
        }
        return new Response((string) $form->getErrors(true, false), 500);
    }

    /**
     * @param $request
     * @param $hashedId : estimation
     * @Rest\Post("/{hashedId}/poste")
     * @Rest\View(serializerGroups={"simple","lignes"})
     */
    public function addPoste(Request $request, $hashedId, Hashids $hashids)
    {
        $id = $hashids->decode($hashedId);
        $estimation = $this->getDoctrine()->getRepository('App:Estimation')->findOneBy(['id'=>$id]);
        if(!$estimation)
            throw new NotFoundHttpException('Estimation not found');
        $poste = new DevisPoste();
        $poste->setEstimation($estimation);
        $poste->setOrdre(0);
        $form = $this->createForm(DevisPosteType::class, $poste);
        $form->submit($request->request->all());
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($poste);
            $em->flush();
            return $poste;
        }
        return new Response((string) $form->getErrors(true, false), 500);
    }

    /**
     * @Rest\Get("")
     * @Rest\View(serializerGroups={"simple","lignes"})
     */
    public function liste()
    {
        $estimations = $this->getDoctrine()->getRepository('App:Estimation')->findAll();
        return $estimations;
    }

    /**
     * @Rest\Get("/{hashedId}")
     * @Rest\View(serializerGroups={"simple","chantier","lignes"})
     */
    public function getEstimation($hashedId, Hashids $hashids)
    {
        $id = $hashids->decode($hashedId);
        $devis = $this->getDoctrine()->getRepository('App:Estimation')->findOneBy(['id'=>$id]);
        if(!$devis)
            throw new NotFoundHttpException('Estimation not found');
        return $devis;
    }

}
