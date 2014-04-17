<?php
/**
 * Created by PhpStorm.
 * User: povlas
 * Date: 4/10/14
 * Time: 6:57 PM
 */

namespace FrameWorkersTM\FoodRescue\FoodAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class SettingsController extends Controller {
    public function indexAction(Request $request)
    {
        $session = $request->getSession();
        $array['logged']= $session->get('logged');
        return $this->render('FrameWorkersTMFoodRescueFoodAppBundle:Settings:index.html.twig', $array);
    }
} 