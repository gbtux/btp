<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index()
    {
        $uriPrefixBL = $this->getParameter('vich_uploader.mappings')['bl_document']['uri_prefix'];
        return $this->render('default/index.html.twig', [
            'uri_prefix_bl' => $uriPrefixBL
        ]);
    }
}
