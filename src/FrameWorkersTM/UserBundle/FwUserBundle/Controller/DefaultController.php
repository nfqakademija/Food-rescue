<?php

namespace FrameWorkersTM\UserBundle\FwUserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('FWUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
