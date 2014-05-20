<?php
/**
 * Created by PhpStorm.
 * User: povlas
 * Date: 4/27/14
 * Time: 7:17 PM
 */

namespace FrameWorkersTM\FoodRescue\FoodAppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ProductListController extends Controller {

    function indexAction() {
        $repository = $this->getDoctrine()
            ->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:Products');
        $products = $repository->findAll();
        $prodNameList = array();
        foreach ($products as $product) {
            $prodNameList[] = array(
                'label' => $product->getName(),
                'value' => $product->getId(),
                'units' => $product->getUnit(),
                'quantity' => $product->getQuantity(),
                'endDate' => date('Y/m/d', time() + ($product->getEndDays() * 24 * 60 * 60))//strtotime("+".$product->getEndDays()." days")
            );
        }
        $response = new Response(json_encode($prodNameList));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
} 