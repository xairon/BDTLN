<?php

namespace Bdtln\TranslationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TranslationController extends Controller
{
    public function indexAction()
    {
        return $this->render('BdtlnTranslationBundle:Translation:dashboard.html.twig');
    }
}
