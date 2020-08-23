<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Prd;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Prd controller.
 *
 * @Route("admin/prd")
 */
class PrdController extends Controller
{
    /**
     * Lists all prd entities.
     *
     * @Route("/", name="admin_prd_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $prds = $em->getRepository('AdminBundle:Prd')->findAll();

        return $this->render('prd/index.html.twig', array(
            'prds' => $prds,
        ));
    }

    /**
     * Creates a new prd entity.
     *
     * @Route("/new", name="admin_prd_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $prd = new Prd();
        $form = $this->createForm('AdminBundle\Form\PrdType', $prd, array("validation_groups" => array("new")));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $file = $prd->getImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('uploads_prd_directory'), $fileName);
           $prd->setImage($fileName);

            $em->persist($prd);
            $em->flush();

            return $this->redirectToRoute('admin_prd_show', array('id' => $prd->getId()));
        }

        return $this->render('prd/new.html.twig', array(
            'prd' => $prd,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a prd entity.
     *
     * @Route("/{id}", name="admin_prd_show")
     * @Method("GET")
     */
    public function showAction(Prd $prd)
    {
        $deleteForm = $this->createDeleteForm($prd);

        return $this->render('prd/show.html.twig', array(
            'prd' => $prd,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing prd entity.
     *
     * @Route("/{id}/edit", name="admin_prd_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Prd $prd)
    {
        $oldPrd = $prd->getImage();
        $deleteForm = $this->createDeleteForm($prd);
        $editForm = $this->createForm('AdminBundle\Form\PrdType', $prd);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {




        if($prd->getImage() == null) {
        $prd->setImage($oldPrd);
        }else{

        $file = $prd->getImage();
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $file->move($this->getParameter('uploads_prd_directory'), $fileName);
        $prd->setImage($fileName);

        }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_prd_index');
        }

        return $this->render('prd/edit.html.twig', array(
            'prd' => $prd,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a prd entity.
     *
     * @Route("/{id}", name="admin_prd_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Prd $prd)
    {
        $form = $this->createDeleteForm($prd);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($prd);
            $em->flush();
        }

        return $this->redirectToRoute('admin_prd_index');
    }

    /**
     * Creates a form to delete a prd entity.
     *
     * @param Prd $prd The prd entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Prd $prd)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_prd_delete', array('id' => $prd->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
