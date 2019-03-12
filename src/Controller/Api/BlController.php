<?php

namespace App\Controller\Api;

use App\Entity\BordereauLivraison;
use App\Form\BordereauLivraisonType;
use Hashids\Hashids;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class BlController
 * @package App\Controller\Api
 * @Rest\Route("/api/livraisons")
 */
class BlController extends AbstractController
{
    /**
     * @Rest\Get("")
     * @Rest\View(serializerGroups={"simple"})
     */
    public function liste()
    {
        $bls = $this->getDoctrine()->getRepository('App:BordereauLivraison')->findAll();
        return $bls;
    }

    /**
     * @param Request $request
     * @Rest\Post("")
     * @Rest\View(serializerGroups={"simple"})
     */
    public function createBl(Request $request)
    {
        $bl = new BordereauLivraison();
        $form = $this->createForm(BordereauLivraisonType::class, $bl);
        $form->submit($request->request->all());
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $request->files->get('document');
            if(null !== $file){
                $extension = $file->guessExtension();
                $target = $this->getParameter('vich_uploader.mappings')['bl_document']['uri_prefix'];
                $target = $this->getParameter('kernel.project_dir') . '/public' . $target;dump($target);
                $filename = uniqid('document_', true) . '.' .$extension;

                if($file->move($target, $filename)) {
                    $bl->setDocument($filename);
                }
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($bl);
            $em->flush();
            return $bl;
        }
        return new Response((string) $form->getErrors(true, false), 500);

    }

    /**
     * @Rest\Get("/{hashedId}")
     * @Rest\View(serializerGroups={"simple"})
     */
    public function getBl($hashedId, Hashids $hashids)
    {
        $id = $hashids->decode($hashedId);
        $bl = $this->getDoctrine()->getRepository('App:BordereauLivraison')->findOneBy(['id' => $id]);
        if(!$bl)
            throw new NotFoundHttpException('Bon de livraison not found');
        return $bl;
    }

}
