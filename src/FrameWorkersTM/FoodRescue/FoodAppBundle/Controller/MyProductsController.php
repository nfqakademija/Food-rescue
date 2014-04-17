<?php
// src/FrameWorkersTm/FoodRescue/FoodAppBundle/Controller/MyProductsController.php

namespace FrameWorkersTM\FoodRescue\FoodAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class MyProductsController extends Controller
{

    private function formRow($name, $quantity, $date, $units) {
        $string = "
            <div class=\"form-group row\"/>
                <div class='col-sm-5 col-md-5 col-lg-5'>
                    <input class=\"form-control\" type=\"text\" value=\"$name\" />
                </div>
                <div class='col-sm-2 col-md-2 col-lg-2'>
                    <input class=\"form-control\" type=\"num\" value=\"$quantity\"/>
                </div>
                <div class='col-sm-1 col-md-2 col-lg-2'>
                    <select class=\"form-control\" form=\"produktai\">
                        <option value=\"g\">g</option>
                        <option value=\"l\" selected='selected' >l</option>
                        <option value=\"vnt\">vnt.</option>
                    </select>
                </div>
                <div class='col-sm-2 col-md-2 col-lg-2'>
                    <input class=\"form-control\" type='date' value='$date'>
                </div>
                <div class='col-sm-1 col-md-1 col-lg-1'>
                    <button type='button' class='form-control'>
                        <span class='glyphicon glyphicon-trash'></span>
                    </button>
                </div>
            </div>
        ";
        return $string;
    }
    public function indexAction(Request $request)
    {

        $session = $request->getSession();
        $array['logged']= $session->get('logged');

        $array['forma'] = $this->formRow('Kiaušiniai', 2, '2014-04-27', 'vnt');
        $array['forma'] .= $this->formRow('Pienas', 0.5, '2014-04-28', 'l');
        $array['forma'] .= $this->formRow('Rūgpienis', 1, '2014-04-28', 'l');
        $array['forma'] .= $this->formRow('Kiauliena', 800, '2014-04-28', 'g');

        return $this->render('FrameWorkersTMFoodRescueFoodAppBundle:MyProducts:index.html.twig', $array);
    }
}