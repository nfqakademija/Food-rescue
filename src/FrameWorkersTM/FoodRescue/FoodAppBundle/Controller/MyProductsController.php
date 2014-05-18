<?php
// src/FrameWorkersTm/FoodRescue/FoodAppBundle/Controller/MyProductsController.php

namespace FrameWorkersTM\FoodRescue\FoodAppBundle\Controller;

use FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\AddMyProduct;
use FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\MyProducts;
use FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\Products;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;

class MyProductsController extends Controller
{
    public function indexAction(Request $request)
    {
        $session = $request->getSession();
        $array['logged']= $session->get('logged');

        $usr = $this->get('security.context')->getToken()->getUser();
        if ($usr == 'anon.') $userId = 0; //neprisijunges
        else $userId = $usr->getId();

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


        if ($addProductForm->isValid()) {

            $productData = $addProductForm->getData();

            $product = new MyProducts();
            $prod = $repository = $this->getDoctrine()
                ->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:Products')
                ->findOneById($productData->getProductId());
            $product->setEndDate(strtotime($productData->getEndDate()))
                ->setQuantity($productData->getQuantity())
                ->setUserId($userId)
                ->setProduct($prod);

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
        }


        $myProducts = $repository = $this->getDoctrine()
            ->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:MyProducts')
            ->findBy(array("userId" => $userId));
        $productEndDates = array();
        foreach ($myProducts as $product) {
            $productEndDates[$product->getId()] = date('Y/m/d',$product->getEndDate());
        }

        $array['addProductForm'] = $addProductForm->createView();
        $array['myProducts'] = $myProducts;
        $array['productEndDates'] = $productEndDates;

        return $this->render('FrameWorkersTMFoodRescueFoodAppBundle:MyProducts:index.html.twig', $array);
    }
    public function editAction(Request $request) {

        $usr = $this->get('security.context')->getToken()->getUser();
        if ($usr == 'anon.') $userId = 0; //neprisijunges
        else $userId = $usr->getId();

        if (array_key_exists('id', $_POST)) {
            $id = $_POST['id'];
            $quantity = $_POST['quantity'];
            $endDate = strtotime($_POST['endDate']);
            $repository = $this->getDoctrine()
                ->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:MyProducts');
            $product = $repository->findOneById($id);
            $product->setQuantity($quantity)->setEndDate($endDate);
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

        }
        return new Response(null);
    }
}