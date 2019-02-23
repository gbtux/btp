<?php

namespace App\Controller\Api;

use App\Entity\DevisArticle;
use App\Entity\DevisPoste;
use App\Entity\DevisSousPoste;
use App\Entity\EventTask;
use App\Form\DevisArticleType;
use App\Form\DevisLigneCommentairesType;
use App\Form\DevisPosteType;
use App\Form\DevisSousPosteType;
use App\Form\EventTaskType;
use Hashids\Hashids;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @param Hashids $hashids
     * @Rest\Put("/poste/{hashedId}")
     * @Rest\View(serializerGroups={"simple","lignes"})
     */
    public function updatePoste(Request $request, $hashedId, Hashids $hashids)
    {
        $pid = $hashids->decode($hashedId);
        $poste = $this->getDoctrine()->getRepository('App:DevisPoste')->findOneBy(['id'=>$pid]);
        if(!$poste)
            throw new NotFoundHttpException('Poste not found');
        $form = $this->createForm(DevisPosteType::class, $poste);
        $form->submit($request->request->all());
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($poste);
            $em->flush();

            $estimation = $this->getDoctrine()->getRepository('App:Estimation')->findOneBy(['id'=>$poste->getEstimation()->getId()]);
            return $estimation;
        }
        return new Response((string) $form->getErrors(true, false), 500);
    }

    /**
     * @Rest\Get("/{hashedId}/ressources")
     */
    public function getRessources($hashedId, Hashids $hashids)
    {
        $id = $hashids->decode($hashedId);
        $estimation = $this->getDoctrine()->getRepository('App:Estimation')->findOneBy(['id'=>$id]);
        if(!$estimation)
            throw new NotFoundHttpException('Estimation not found');
        $res = [];
        foreach ($estimation->getPostes() as $poste ) {
            $current = $poste->getTitre();
            foreach ($poste->getArticles() as $article) {
                $res[] = ['id' => $hashids->encode($article->getId()), 'title' => $article->getDesignation(), 'poste' => $current, 'type' => 'article'];
            }
            foreach ($poste->getSousPostes() as $ssPoste) {
                $cPoste = $current . ' - ' . $ssPoste->getTitre();
                foreach ($ssPoste->getArticles() as $spArticle) {
                    $res[] = ['id' => $hashids->encode($spArticle->getId()), 'title' => $spArticle->getDesignation(), 'poste' => $cPoste, 'type' => 'article'];
                }
            }

        }
        return new JsonResponse($res);
    }

    /**
     * @Rest\Get("/{hashedId}/tasks")
     * @Rest\View(serializerGroups={"simple"})
     */
    public function getTasks(Request $request, $hashedId, Hashids $hashids)
    {
        $rStart = $request->get('start');
        $rEnd = $request->get('end');
        $tasks = $this->getDoctrine()->getRepository('App:EventTask')->searchByDates($rStart, $rEnd);
        return $tasks;
    }

    /**
     * @param Request $request
     * @param $hashedId
     * @param Hashids $hashids
     * @Rest\Post("/{hashedId}/task")
     * @Rest\View(serializerGroups={"simple","lignes"})
     */
    public function creerTacheCalendrier(Request $request, $hashedId, Hashids $hashids)
    {
        $id = $hashids->decode($hashedId);
        $estimation = $this->getDoctrine()->getRepository('App:Estimation')->findOneBy(['id'=>$id]);
        if(!$estimation)
            throw new NotFoundHttpException('Estimation not found');
        $task = new EventTask();
        $task->setEstimation($estimation);
        $form = $this->createForm(EventTaskType::class, $task);
        $form->submit($request->request->all());
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();
            return $task;
        }
        return new Response((string) $form->getErrors(true, false), 500);
    }

    /**
     * @param Request $request
     * @param $hashedId
     * @param Hashids $hashids
     * @Rest\Put("/{hashedId}/task")
     * @Rest\View(serializerGroups={"simple","lignes"})
     */
    public function updateTacheCalendrier(Request $request, $hashedId, Hashids $hashids)
    {
        $id = $hashids->decode($hashedId);
        $task = $this->getDoctrine()->getRepository('App:EventTask')->findOneBy(['id'=>$id]);
        if(!$task)
            throw new NotFoundHttpException('Task not found');
        $form = $this->createForm(EventTaskType::class, $task);
        $form->submit($request->request->all());
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();
            return $task;
        }
        return new Response((string) $form->getErrors(true, false), 500);
    }

    /**
     * @param Request $request
     * @param $hashedId
     * @param Hashids $hashids
     * @Rest\Put("/{estimationId}/sousposte/{hashedId}")
     * @Rest\View(serializerGroups={"simple","lignes"})
     */
    public function updateSousPoste(Request $request, $estimationId, $hashedId, Hashids $hashids)
    {
        $id = $hashids->decode($estimationId);
        $estimation = $this->getDoctrine()->getRepository('App:Estimation')->findOneBy(['id'=>$id]);
        if(!$estimation)
            throw new NotFoundHttpException('Estimation not found');
        $pid = $hashids->decode($hashedId);
        $sposte = $this->getDoctrine()->getRepository('App:DevisSousPoste')->findOneBy(['id'=>$pid]);
        if(!$sposte)
            throw new NotFoundHttpException('Sous Poste not found');
        $form = $this->createForm(DevisSousPosteType::class, $sposte);
        $form->submit($request->request->all());
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($sposte);
            $em->flush();

            $estimation = $this->getDoctrine()->getRepository('App:Estimation')->findOneBy(['id'=>$id]);
            return $estimation;
        }
        return new Response((string) $form->getErrors(true, false), 500);
    }

    /**
     * @param Request $request
     * @param $estimationId
     * @param $hashedId
     * @param Hashids $hashids
     * @Rest\Put("/{estimationId}/article/{hashedId}")
     * @Rest\View(serializerGroups={"simple","lignes"})
     */
    public function updateArticle(Request $request, $estimationId, $hashedId, Hashids $hashids)
    {
        $id = $hashids->decode($estimationId);
        $estimation = $this->getDoctrine()->getRepository('App:Estimation')->findOneBy(['id'=>$id]);
        if(!$estimation)
            throw new NotFoundHttpException('Estimation not found');
        $aid = $hashids->decode($hashedId);
        $article = $this->getDoctrine()->getRepository('App:DevisArticle')->findOneBy(['id'=>$aid]);
        if(!$article)
            throw new NotFoundHttpException('Article not found');
        $form = $this->createForm(DevisArticleType::class, $article);
        $form->submit($request->request->all());
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
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

        $article = new DevisArticle();
        $article->setOrdre(0);
        $form = $this->createForm(DevisArticleType::class, $article);
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
        $sousPoste = new DevisSousPoste();
        $sousPoste->setPoste($poste);
        $sousPoste->setOrdre(0);
        $form = $this->createForm(DevisSousPosteType::class, $sousPoste);
        $form->submit($request->request->all());
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($sousPoste);
            $em->flush();

            $estimation = $this->getDoctrine()->getRepository('App:Estimation')->findOneBy(['id'=>$id]);
            return $estimation;
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
