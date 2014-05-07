<?php
// src/FrameWorkersTm/FoodRescue/FoodAppBundle/Controller/MyProductsController.php

namespace FrameWorkersTM\FoodRescue\FoodAppBundle\Controller;

use FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\AddMyProduct;
use FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\MyProducts;
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
    public function productsTable() {


    }
    public function indexAction(Request $request)
    {

        $session = $request->getSession();
        $array['logged']= $session->get('logged');

        $addNewProduct = new AddMyProduct();
        $addProductFormBuilder = $this->container
            ->get('form.factory')
            ->createNamedBuilder('addProductForm', 'form', $addNewProduct, array('validation_groups' => array()))
            ->add('productName', 'text')
            ->add('productID', 'hidden')
            ->add('quantity', 'number')
            ->add('endDate', 'text')//'date', array('widget' => 'single_text', 'format' => 'yyyy-MM-dd'))
            ->add('submit', 'submit');
        $addProductForm = $addProductFormBuilder
            ->getForm()
            ->handleRequest($request);

        if ($addProductForm->isValid()) {
            $productData = $addProductForm->getData();
            $product = new MyProducts();
            $product->setEndDate($productData->getEndDate())
                ->setQuantity($productData->getQuantity())
                ->setUsersId($session->getId())
                ->setProductsId($productData->getProductID());

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
        }
        $myProducts = $repository = $this->getDoctrine()
            ->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:MyProducts')
            ->findBy(array("usersId" => $session->getId()));
        $myProductsArray = array();
        foreach($myProducts as $product) {
            $myProductsArray[$product->getProductsId()] =
                array(
                    "name" => $product->getProduct()->getName(),
                    "units" => $product->getProduct()->getUnits()
                );
        }






        $array['forma'] = $this->formRow('Kiaušiniai', 2, '2014-04-27', 'vnt');
        $array['forma'] .= $this->formRow('Pienas', 0.5, '2014-04-28', 'l');
        $array['forma'] .= $this->formRow('Rūgpienis', 1, '2014-04-28', 'l');
        $array['forma'] .= $this->formRow('Kiauliena', 800, '2014-04-28', 'g');
        $array['addProductForm'] = $addProductForm->createView();
        $array['myProducts'] = $myProducts;
        $array['myProductsArray'] = $myProductsArray;

        return $this->render('FrameWorkersTMFoodRescueFoodAppBundle:MyProducts:index.html.twig', $array);
    }
}