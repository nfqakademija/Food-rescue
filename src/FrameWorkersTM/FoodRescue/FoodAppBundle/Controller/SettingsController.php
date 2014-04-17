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
        $settingsForm = $this->createFormBuilder()
            ->add('email', 'email', array(
                'label' => 'El. paštas'
            ))
            ->add('notificationTime', 'integer', array(
                'label' => 'Priminti apie besibaigiančius produktus likus dienų: '
            ))
            ->add('sortRecipies', 'choice', array(
                'label' => 'Receptus rūšiuoti pagal',
                'choices' => array(
                    'endDate' => 'greičiausiai pasibaigsiančius produktus',
                    'favourites' => 'pomėgius'
                )
            ))
            ->getForm();

        return $this->render('FrameWorkersTMFoodRescueFoodAppBundle:Settings:index.html.twig', array(
            'settingsForm' => $settingsForm->createView(),
        ));
    }
} 