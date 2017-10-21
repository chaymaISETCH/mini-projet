<?php

namespace authenBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('authenBundle:Default:index.html.twig');
    }
}
