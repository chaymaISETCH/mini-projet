<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Userr;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Userr controller.
 *
 * @Route("userr")
 */
class UserrController extends Controller
{
    /**
     * Lists all userr entities.
     *
     * @Route("/", name="userr_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $userrs = $em->getRepository('AppBundle:Userr')->findAll();

        return $this->render('userr/index.html.twig', array(
            'userrs' => $userrs,
        ));
    }

    /**
     * Creates a new userr entity.
     *
     * @Route("/new", name="userr_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $userr = new Userr();
        $form = $this->createForm('AppBundle\Form\UserrType', $userr);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($userr);
            $em->flush();

            return $this->redirectToRoute('userr_show', array('id' => $userr->getId()));
        }

        return $this->render('userr/new.html.twig', array(
            'userr' => $userr,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a userr entity.
     *
     * @Route("/{id}", name="userr_show")
     * @Method("GET")
     */
    public function showAction(Userr $userr)
    {
        $deleteForm = $this->createDeleteForm($userr);

        return $this->render('userr/show.html.twig', array(
            'userr' => $userr,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing userr entity.
     *
     * @Route("/{id}/edit", name="userr_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Userr $userr)
    {
        $deleteForm = $this->createDeleteForm($userr);
        $editForm = $this->createForm('AppBundle\Form\UserrType', $userr);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('userr_edit', array('id' => $userr->getId()));
        }

        return $this->render('userr/edit.html.twig', array(
            'userr' => $userr,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a userr entity.
     *
     * @Route("/{id}", name="userr_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Userr $userr)
    {
        $form = $this->createDeleteForm($userr);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($userr);
            $em->flush();
        }

        return $this->redirectToRoute('userr_index');
    }

    /**
     * Creates a form to delete a userr entity.
     *
     * @param Userr $userr The userr entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Userr $userr)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('userr_delete', array('id' => $userr->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
