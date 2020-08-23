<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class FromController extends Controller
{
    /**
     * @Route("/form")
     */
    public function indexAction()
    {
        return $this->render('default/formorder.html.twig', array(
            // ...
        ));
    }

}
