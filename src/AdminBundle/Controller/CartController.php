<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Prd;
use AdminBundle\Entity\Orders;
use AdminBundle\Entity\Customer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class CartController extends Controller
{
    /**
     * 
     *
     * @Route("/showcart", name="showcart")
     * @Method("GET")
     * @Template()
     */
    public function showCartAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $prdRepository = $em->getRepository('AdminBundle:Prd');
        $prdsArray = [];
        $cart = [];
        $totalSum = 0;

        $cookies = $request->cookies->all();

        if (isset($cookies['cart'])) {
            $cart = json_decode($cookies['cart']);
        }

        foreach ($cart as $prdId => $prdQuantity) {
            /**
             * @var Prd $prd
             */
            $prd = $prdRepository->find((int)$prdId);
            if (is_object($prd)) {
                $prdPosition = [];

                $quantity = abs((int)$prdQuantity);
                $price = $prd->getPrice();
                $sum = $price * $quantity;

                $prdPosition['prd'] = $prd;
                $prdPosition['quantity'] = $quantity;
                $prdPosition['price'] = $price;
                $prdPosition['sum'] = $sum;
                $totalSum += $sum;

                $prdArray[] = $prdPosition;
            }
        }

        return [
                'totalsum' => $totalSum
        ];
    }
}