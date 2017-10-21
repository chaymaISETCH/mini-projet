<?php

namespace authenBundle\Controller;

use authenBundle\Entity\MgUser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Mguser controller.
 *
 * @Route("mguser")
 */
class MgUserController extends Controller
{
    /**
     * Lists all mgUser entities.
     *
     * @Route("/", name="mguser_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $mgUsers = $em->getRepository('authenBundle:MgUser')->findAll();

        return $this->render('mguser/index.html.twig', array(
            'mgUsers' => $mgUsers,
        ));
    }

    /**
     * Creates a new mgUser entity.
     *
     * @Route("/new", name="mguser_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $mgUser = new Mguser();
        $form = $this->createForm('authenBundle\Form\MgUserType', $mgUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mgUser);
            $em->flush();

            return $this->redirectToRoute('mguser_show', array('id' => $mgUser->getId()));
        }

        return $this->render('mguser/new.html.twig', array(
            'mgUser' => $mgUser,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a mgUser entity.
     *
     * @Route("/{id}", name="mguser_show")
     * @Method("GET")
     */
    public function showAction(MgUser $mgUser)
    {
        $deleteForm = $this->createDeleteForm($mgUser);

        return $this->render('mguser/show.html.twig', array(
            'mgUser' => $mgUser,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing mgUser entity.
     *
     * @Route("/{id}/edit", name="mguser_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MgUser $mgUser)
    {
        $deleteForm = $this->createDeleteForm($mgUser);
        $editForm = $this->createForm('authenBundle\Form\MgUserType', $mgUser);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mguser_edit', array('id' => $mgUser->getId()));
        }

        return $this->render('mguser/edit.html.twig', array(
            'mgUser' => $mgUser,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a mgUser entity.
     *
     * @Route("/{id}", name="mguser_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MgUser $mgUser)
    {
        $form = $this->createDeleteForm($mgUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mgUser);
            $em->flush();
        }

        return $this->redirectToRoute('mguser_index');
    }

    /**
     * Creates a form to delete a mgUser entity.
     *
     * @param MgUser $mgUser The mgUser entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MgUser $mgUser)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mguser_delete', array('id' => $mgUser->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
