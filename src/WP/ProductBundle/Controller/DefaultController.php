<?php

namespace WP\ProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * Ajax view product
     *
     * @Route("/ajax/product/{id}", name="product_ajax_view")
     */
    public function ajaxViewAction($id)
    {
        $request = $this->get('request');
        $session = $request->getSession();

        $cart = $session->get('cart', ["items" => [], "count" => 0]);

        $product = $this->getDoctrine()->getRepository('WPProductBundle:Product')->find($id);

        if (null == $product) {
            throw $this->createNotFoundException('Продукт не найден');
        }

        return $this->render('WPProductBundle:Default:_ajax-view.html.twig', [
            'cart' => $cart,
            'product' => $product
        ]);
    }
}
