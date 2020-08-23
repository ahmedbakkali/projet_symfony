<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Orders;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Order controller.
 *
 * @Route("admin/orders")
 */
class OrdersController extends Controller
{
    /**
     * Lists all order entities.
     *
     * @Route("/", name="admin_orders_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $orders = $em->getRepository('AdminBundle:Orders')->findAll();

        return $this->render('orders/index.html.twig', array(
            'orders' => $orders,
        ));
    }

    /**
     * Finds and displays a order entity.
     *
     * @Route("/{id}", name="admin_orders_show")
     * @Method("GET")
     */
    public function showAction(Orders $order)
    {

        return $this->render('orders/show.html.twig', array(
            'order' => $order,
        ));
    }
}
