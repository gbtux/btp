<?php

namespace App\Controller;

use Hashids\Hashids;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class PrintController extends AbstractController
{
    /**
     * @Route("/print/estimation/{hashedId}/all", name="print_estimation_all")
     */
    public function index($hashedId, Hashids $hashids)
    {
        $id = $hashids->decode($hashedId);
        $estimation = $this->getDoctrine()->getRepository('App:Estimation')->findOneBy(['id'=>$id]);
        if(!$estimation)
            throw new NotFoundHttpException('Estimation not found');
        return $this->render('print/estimation_all.html.twig', [
            'estimation' => $estimation
        ]);
    }
}
