<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * Admin controller.
 *
 * @Route("admin")
 */


class AdminController extends Controller
{
    /**
     * 
     *
     * @Route("/", name="admin_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->render('AdminBundle:Admin:index.html.twig', array(
            // ...
        ));
    }

}
