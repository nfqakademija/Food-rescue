<?php
/**
 * Created by PhpStorm.
 * User: povlas
 * Date: 4/10/14
 * Time: 6:57 PM
 */

namespace FrameWorkersTM\FoodRescue\FoodAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
class SettingsController extends Controller {
    public function indexAction()
    {
        return $this->render('FrameWorkersTMFoodRescueFoodAppBundle:Settings:index.html.twig');
    }
} 