<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Booking;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use http\Exception\UnexpectedValueException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Booking controller.
 *
 * @Route("booking")
 */
class BookingController extends Controller
{
    /**
     * Lists all booking entities.
     *
     * @Route("/", name="booking_index", methods={"GET"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $bookings = $em->getRepository('AppBundle:Booking')->findAll();

        return $this->render('booking/index.html.twig', array(
            'bookings' => $bookings,
        ));
    }

    /**
     * @Route("/calendar", name="booking_calendar", methods={"GET"})
     */
    public function calendar()
    {
        $em = $this->getDoctrine()->getManager();

        $bookings = $em->getRepository('AppBundle:Booking')->findAll();

        return $this->render('booking/calendar.html.twig', array(
            'bookings' => $bookings,
        ));
    }

    /**
     * Creates a new booking entity.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     *
     * @Route("/new", name="booking_new", methods={"GET", "POST"})
     *
     * @throws \Exception
     */
    public function newAction(Request $request)
    {
        $booking = new Booking();
        $form = $this->createForm('AppBundle\Form\BookingType', $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Set color by color on supervisor
            $booking->setColor($booking->getSupervisor()->getColor());

            $em = $this->getDoctrine()->getManager();

                //$group = $em->getRepository(Booking::class)->findBy(["course" => $booking->getCourse()]);
                //$em->getRepository(Booking::class)->findBy(["course" => $booking->getCourse()]);
                //dump($booking->getCourse());
                //exit();

                //Check Date by begin_at
                $date_begin = $em->getRepository(Booking::class)->findOneBy(["beginAt" => $booking->getBeginAt()]);
                $date_begin = $date_begin->getBeginAt();

                //Check Date by end_at
                $date_end = $em->getRepository(Booking::class)->findOneBy(["endAt" => $booking->getEndAt()]);
                $date_end = $date_end->getEndAt();

                if ($date_begin == $booking->getBeginAt() || $date_end == $booking->getEndAt()) {

                    throw new InvalidArgumentException("Vous ne pouvez pas se faire superposé des cours pour la même classe");
                }




            $em->persist($booking);
            $em->flush();

            return $this->redirectToRoute('booking_show', array('id' => $booking->getId()));
        }

        return $this->render('booking/new.html.twig', array(
            'booking' => $booking,
            'form' => $form->createView(),
        ));
    }



    /**
     * Finds and displays a booking entity.
     *
     * @param Booking $booking
     * @return Response
     *
     * @Route("/{id}", name="booking_show" , methods={"GET"})
     */
    public function showAction(Booking $booking)
    {
        $deleteForm = $this->createDeleteForm($booking);

        return $this->render('booking/show.html.twig', array(
            'booking' => $booking,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing booking entity.
     *
     * @param Request $request
     * @param Booking $booking
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     *
     * @Route("/{id}/edit", name="booking_edit", methods={"GET", "POST"})
     */
    public function editAction(Request $request, Booking $booking)
    {
        $deleteForm = $this->createDeleteForm($booking);
        $editForm = $this->createForm('AppBundle\Form\BookingType', $booking);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('booking_edit', array('id' => $booking->getId()));
        }

        return $this->render('booking/edit.html.twig', array(
            'booking' => $booking,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a booking entity.
     *
     * @param Request $request
     * @param Booking $booking
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/{id}", name="booking_delete", methods={"DELETE"})
     */
    public function deleteAction(Request $request, Booking $booking)
    {
        $form = $this->createDeleteForm($booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($booking);
            $em->flush();
        }

        return $this->redirectToRoute('booking_index');
    }

    /**
     * Creates a form to delete a booking entity.
     *
     * @param Booking $booking The booking entity
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createDeleteForm(Booking $booking)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('booking_delete', array('id' => $booking->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
