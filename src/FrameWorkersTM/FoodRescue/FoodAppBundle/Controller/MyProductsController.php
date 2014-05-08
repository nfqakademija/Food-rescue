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
    public function indexAction(Request $request)
    {

        $session = $request->getSession();
        $array['logged']= $session->get('logged');

        $addNewProduct = new AddMyProduct();
        $addProductFormBuilder = $this->container
            ->get('form.factory')
            ->createNamedBuilder('addProductForm', 'form', $addNewProduct, array('validation_groups' => array()))
            ->add('productName', 'text')
            ->add('productId', 'number')
            ->add('quantity', 'number')
            ->add('endDate', 'text')
            ->add('submit', 'submit');
        $addProductForm = $addProductFormBuilder
            ->getForm()
            ->handleRequest($request);


        $aa = new MyProducts();
        $aa->setProductId(1);
        $aa->setUserId(1);
        $aa->setQuantity(1);
        $aa->setEndDate(1);

        print_r($aa);

        $em = $this->getDoctrine()->getManager();
        $em->persist($aa);
        $em->flush();

        /*if ($addProductForm->isValid()) {
            $productData = $addProductForm->getData();
            $product = new MyProducts();
            $product->setEndDate(strtotime($productData->getEndDate()))
                ->setQuantity($productData->getQuantity())
                ->setUserId($session->getId())
                ->setProductId(2);//$productData->getProductId());

            $em = $this->getDoctrine()->getManager();
            print_r($product);

            $em->persist($product);
            $em->flush();
        }*/
        $myProducts = $repository = $this->getDoctrine()
            ->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:MyProducts')
            ->findBy(array("userId" => $session->getId()));

        $array['addProductForm'] = $addProductForm->createView();
        $array['myProducts'] = $myProducts;

        return $this->render('FrameWorkersTMFoodRescueFoodAppBundle:MyProducts:index.html.twig', $array);
    }
}