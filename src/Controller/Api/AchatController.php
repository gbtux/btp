<?php

namespace App\Controller\Api;

use App\Entity\Achat;
use App\Form\AchatType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class AchatController
 * @package App\Controller\Api
 * @Rest\Route("/api/achats")
 */
class AchatController extends AbstractController
{
    /**
     * @Rest\Get("/categories")
     * @Rest\View(serializerGroups={"simple"})
     */
    public function liste()
    {
        $cs = $this->getDoctrine()->getRepository('App:AchatCategorie')->findAll();
        return $cs;
    }

    /**
     * @param Request $request
     * @Rest\Post("")
     * @Rest\View(serializerGroups={"simple"})
     */
    public function createAchat(Request $request)
    {
        $achat = new Achat();
        $form = $this->createForm(AchatType::class, $achat);
        $form->submit($request->request->all());
        if ($form->isSubmitted() && $form->isValid()) {
            $achat->setDateCreation(new \DateTime());
            $file = $request->files->get('document');
            if(null !== $file){
                $extension = $file->guessExtension();
                $target = $this->getParameter('vich_uploader.mappings')['achat_document']['uri_prefix'];
                $target = $this->getParameter('kernel.project_dir') . '/public' . $target;
                $filename = uniqid('document_', true) . '.' .$extension;

                if($file->move($target, $filename)) {
                    $achat->setDocument($filename);
                }
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($achat);
            $em->flush();
            return $achat;
        }
        return new Response((string) $form->getErrors(true, false), 500);

    }
}
