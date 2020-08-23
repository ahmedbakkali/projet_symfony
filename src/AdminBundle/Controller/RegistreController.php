<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Registre;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Registre controller.
 *
 * @Route("registre")
 */
class RegistreController extends Controller
{
    /**
     * Lists all registre entities.
     *
     * @Route("/", name="registre_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $registres = $em->getRepository('AdminBundle:Registre')->findAll();

        return $this->render('registre/index.html.twig', array(
            'registres' => $registres,
        ));
    }

    /**
     * Creates a new registre entity.
     *
     * @Route("/new", name="registre_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $registre = new Registre();
        $form = $this->createForm('AdminBundle\Form\RegistreType', $registre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($registre);
            $em->flush();

            return $this->redirectToRoute('registre_show', array('id' => $registre->getId()));
        }

        return $this->render('registre/new.html.twig', array(
            'registre' => $registre,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a registre entity.
     *
     * @Route("/{id}", name="registre_show")
     * @Method("GET")
     */
    public function showAction(Registre $registre)
    {
        $deleteForm = $this->createDeleteForm($registre);

        return $this->render('registre/show.html.twig', array(
            'registre' => $registre,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing registre entity.
     *
     * @Route("/{id}/edit", name="registre_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Registre $registre)
    {
        $deleteForm = $this->createDeleteForm($registre);
        $editForm = $this->createForm('AdminBundle\Form\RegistreType', $registre);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('registre_edit', array('id' => $registre->getId()));
        }

        return $this->render('registre/edit.html.twig', array(
            'registre' => $registre,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a registre entity.
     *
     * @Route("/{id}", name="registre_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Registre $registre)
    {
        $form = $this->createDeleteForm($registre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($registre);
            $em->flush();
        }

        return $this->redirectToRoute('registre_index');
    }

    /**
     * Creates a form to delete a registre entity.
     *
     * @param Registre $registre The registre entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Registre $registre)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('registre_delete', array('id' => $registre->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
