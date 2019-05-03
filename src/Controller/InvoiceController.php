<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class InvoiceController
 * @package App\Controller
 * @deprecated DO NOT USE IT :
 */
class InvoiceController extends AbstractController
{
    /**
     * @Route("/invoice", name="invoice")
     */
    public function index()
    {
        return $this->render('invoice/index.html.twig', [
            'controller_name' => 'InvoiceController',
        ]);
    }
}
