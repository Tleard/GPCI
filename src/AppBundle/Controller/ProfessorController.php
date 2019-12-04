<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Booking;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Booking controller.
 *
 * @Route("/professor")
 */
class ProfessorController extends Controller
{
    /**
     * Creates a new booking (With Default unavailability).
     *
     * @param Request $request
     * @return RedirectResponse|Response
     *
     * @Route("/", name="professor_show", methods={"GET", "POST"})
     *
     */
    public function newAction(Request $request)
    {
        $booking = new Booking();
        $user = $this->getUser();
        $booking->setSupervisor($user);
        $booking->setColor('grey');
        $booking->setRoom(1);
        /** When unavailability is equal to true Supervisor is not Available */
        $booking->setUnavailability(true);
        $form = $this->createForm('AppBundle\Form\SupervisorBookingType', $booking);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($booking);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }
        return $this->render('professor/show.html.twig', array(
            'booking' => $booking,
            'form' => $form->createView(),
        ));
    }

/*    /**
     * Creates a form to delete a Booking entity.
     *
     * @param Booking $booking The booking entity
     *
     * @return FormInterface
     *
    private function createDeleteForm(Booking $booking)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('supervisor_delete', array('id' => $booking->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }*/
}
