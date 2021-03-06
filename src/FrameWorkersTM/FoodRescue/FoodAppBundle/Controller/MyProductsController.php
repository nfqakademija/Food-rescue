<?php
// src/FrameWorkersTm/FoodRescue/FoodAppBundle/Controller/MyProductsController.php

namespace FrameWorkersTM\FoodRescue\FoodAppBundle\Controller;

use FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\AddMyProduct;
use FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\MyProducts;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
use FrameWorkersTM\FoodRescue\FoodAppBundle\Services;

class MyProductsController extends Controller
{

    public function indexAction(Request $request)
    {
        $userId = $this->get('recipeservice')->findUser($request->getSession());

        $addNewProduct = new AddMyProduct();
        $addProductFormBuilder = $this->container
            ->get('form.factory')
            ->createNamedBuilder('addProductForm', 'form', $addNewProduct, array('validation_groups' => array()))
            ->add('productName', 'text')
            ->add('productId', 'hidden')
            ->add('quantity', 'number')
            ->add('endDate', 'text')
            ->add('submit', 'submit');
        $addProductForm = $addProductFormBuilder
            ->getForm()
            ->handleRequest($request);

        $productIdError = false;
        if ($addProductForm->isValid()) {

            $productData = $addProductForm->getData();
            $productIdError = $productData->getProductId() == "";
            if (! $productIdError) {
                $product = new MyProducts();
                $prod = $this->getDoctrine()
                    ->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:Products')
                    ->findOneById($productData->getProductId());
                $product->setEndDate(strtotime($productData->getEndDate()))
                    ->setQuantity($productData->getQuantity())
                    ->setUserId($userId)
                    ->setProduct($prod);

                $em = $this->getDoctrine()->getManager();
                $em->persist($product);
                $em->flush();

                //update available recipes
                //$this->get('recipeservice')->findAndSaveAvailableUserRecipes($userId);
            }

        }

        // check for ended products
        $this->get('recipeservice')->findTrashedProducts($userId,$request);

        $myProducts = $this->getDoctrine()
            ->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:MyProducts')
            ->findBy(array("userId" => $userId));
        usort($myProducts, function ($a, $b) {
            return $a->getEndDate() > $b->getEndDate();
        });
        $endsSoon = array();
        $productEndDates = array();
        foreach ($myProducts as $product) {
            $productEndDates[$product->getId()] = date('Y/m/d',$product->getEndDate());
            $endsSoon[$product->getId()] = $product->getEndDate() < time() + 60 * 60 * 24 * 3;
        }

        $array = array();
        $array['endsSoon'] = $endsSoon;
        $array['myProducts'] = $myProducts;
        $array['productEndDates'] = $productEndDates;
        $array['addProductForm'] = $addProductForm->createView();
        $array['productIdError'] = $productIdError;

        return $this->render('FrameWorkersTMFoodRescueFoodAppBundle:MyProducts:index.html.twig', $array);
    }
    public function editAction(Request $request) {
        if (array_key_exists('id', $_POST) && array_key_exists('quantity', $_POST) && array_key_exists('endDate', $_POST)) {
            //$userId = $this->get('recipeservice')->findUser($request->getSession());
            $errors = array();
            $id = $_POST['id'];
            $quantity = $_POST['quantity'];
            if (! is_numeric($quantity) || $quantity <= 0) $errors[] = 'Blogai įvestas kiekis!';
            $endDate = strtotime($_POST['endDate']);
            if ($endDate < time()) $errors[] = 'Data negali būti senesnė nei šios dienos!';

            if (count($errors) < 1) {
                $repository = $this->getDoctrine()
                    ->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:MyProducts');
                $product = $repository->findOneById($id);
                $product->setQuantity($quantity)->setEndDate($endDate);
                $em = $this->getDoctrine()->getManager();
                $em->persist($product);
                $em->flush();

                //update available recipes
                //$this->get('recipeservice')->findAndSaveAvailableUserRecipes($userId);
                return new Response(null);
            } else return new Response(json_encode($errors));


        } else return new Response('BAD POST MESSAGE');
    }
    public function deleteAction(Request $request) {
        if (array_key_exists('id', $_POST)) {
            $userId = $this->get('recipeservice')->findUser($request->getSession());
            $id = $_POST['id'];
            $repository = $this->getDoctrine()
                ->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:MyProducts');
            $product = $repository->findOneById($id);
            if ($product->getUserId() == $userId) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($product);
                $em->flush();

                //update available recipes
                //$this->get('recipeservice')->findAndSaveAvailableUserRecipes($userId);

                return new Response('deleted');
            } else return new Response('Not your product!');
        } else return new Response('Bad request');

    }
}