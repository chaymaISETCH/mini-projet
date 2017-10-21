<?php

namespace authenBundle\Controller;
use Symfony\Component\HttpFoundation\Response;
use authenBundle\Entity\client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Client controller.
 *
 * @Route("client")
 */
class clientController extends Controller
{
    /**
     * Lists all client entities.
     *
     * @Route("/", name="client_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $clients = $em->getRepository('authenBundle:client')->findAll();

        return $this->render('client/index.html.twig', array(
            'clients' => $clients,
        ));
    }

    /**
     * Creates a new client entity.
     *
     * @Route("/new{}{}", name="client_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
$s = $request->query->get('login');
$s2 = $request->query->get('password');
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mg";

try {
    	$conn = new \PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    }
catch(PDOException $e)
    {
    	die("OOPs something went wrong PHP".$e->getMessage());
    }
$data = $conn->query("SELECT * FROM client where login='".$s."' and password='".$s2."'")->fetchAll();
if($data == null)
	return new Response('false');
else
		return new Response('true');

    }

    /**
     * Finds and displays a client entity.
     *
     * @Route("/{password}", name="client_show")
     * @Method("GET")
     */
    public function showAction(client $client)
    {
        $deleteForm = $this->createDeleteForm($client);

        return $this->render('client/show.html.twig', array(
            'client' => $client,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing client entity.
     *
     * @Route("/{password}/edit", name="client_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, client $client)
    {
        $deleteForm = $this->createDeleteForm($client);
        $editForm = $this->createForm('authenBundle\Form\clientType', $client);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('client_edit', array('password' => $client->getPassword()));
        }

        return $this->render('client/edit.html.twig', array(
            'client' => $client,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a client entity.
     *
     * @Route("/{password}", name="client_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, client $client)
    {
        $form = $this->createDeleteForm($client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($client);
            $em->flush();
        }

        return $this->redirectToRoute('client_index');
    }

    /**
     * Creates a form to delete a client entity.
     *
     * @param client $client The client entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(client $client)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('client_delete', array('password' => $client->getPassword())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
