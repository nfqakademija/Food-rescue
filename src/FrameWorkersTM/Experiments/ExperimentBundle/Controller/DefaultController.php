<?php

namespace FrameWorkersTM\Experiments\ExperimentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('FWExperimentsBundle:Default:index.html.twig', array('name' => $name));
    }
}
