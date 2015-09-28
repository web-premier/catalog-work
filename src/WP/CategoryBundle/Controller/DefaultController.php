<?php

namespace WP\CategoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * Display category
     *
     * @Route("/catalog/{id}-{slug}", name="catalog_list")
     * @Template()
     */
    public function listAction($slug, $id)
    {
        $request = $this->get('request');
        $session = $request->getSession();

        $cart = $session->get('cart', ["items" => [], "count" => 0]);

        $category = $this->getDoctrine()->getRepository('WPCategoryBundle:Category')->findOneBy(['slug' => $slug, 'id' => $id]);

        if (null === $category) {
            throw $this->createNotFoundException('Категория не найдена');
        }

        $breadcrumbs = $this->get('white_october_breadcrumbs');
        $breadcrumbs->addItem('Главная', $this->get('router')->generate('homepage'));
        if($category->getParent()){
            $breadcrumbs->addItem($category->getParent()->getTitle(), $this->get('router')->generate('catalog_list', ["id" => $category->getParent()->getId(), "slug" => $category->getParent()->getSlug()]));
        }
        $breadcrumbs->addItem($category->getTitle(), $this->get('router')->generate('catalog_list', ["id" => $category->getId(), "slug" => $category->getSlug()]));

        return [
            'cart' => $cart,
            'category' => $category,
            'categories' => $this->getDoctrine()->getRepository('WPCategoryBundle:Category')->getMainCategories()
        ];
    }
}
