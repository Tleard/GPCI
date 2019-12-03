<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Courses;
use AppBundle\Form\CoursesType;
use AppBundle\Manager\CoursesManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package AppBundle\Controlle
 *
 * @Route("/courses")
 */
class CoursesController extends Controller
{
    /**
     * Lists all booking entities.
     *
     * @Route("/", name="courses_index", methods={"GET"})
     * @param CoursesManager $coursesManager
     * @return Response
     */
    public function indexAction(CoursesManager $coursesManager)
    {
        $courses = $this->getDoctrine()->getRepository('AppBundle:Courses')->findAll();

        return $this->render(':admin:index.html.twig', array(
            'courses' => $courses
        ));
    }

    /**
     * @param Request $request
     * @param CoursesManager $coursesManager
     * @return Response
     *
     * @Route("/create", name="courses_create", methods={"GET", "POST"})
     */
    public function newAction(Request $request, CoursesManager $coursesManager): Response
    {
        $name = "";
        $courses = new Courses();
        $form = $this->createForm(CoursesType::class, $courses, array(
            'action' => $this->generateUrl('courses_create')
        ));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $coursesManager->createOrUpdate($courses);
            $this->addFlash('success', "La matière ''" . $courses->getName() . "'' à bien été crée.");
            return $this->redirectToRoute('admin_index');
        }

        return $this->render('admin/new_courses.html.twig', array(
            'form' => $form->createView(),
            'courses' => $courses
        ));
    }

    /**
     * @param Request $request
     * @param Courses $courses
     * @param CoursesManager $coursesManager
     * @return Response
     *
     * @Route("/edit/{courses}", name="courses_edit", methods={"GET", "POST"})
     */
    public function editAction(Request $request, Courses $courses, CoursesManager $coursesManager): Response
    {
        $form = $this->createForm(CoursesType::class, $courses, array(
            'action' => $this->generateUrl('courses_edit', array(
                'courses' => $courses->getId()
            ))
        ));;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $coursesManager->createOrUpdate($courses);
            $this->addFlash('success', "La matière ''" . $courses->getName() . "'' à bien été mis-à-jour.");
            return $this->redirectToRoute('admin_index');
        }

        return $this->render('admin/new_group.html.twig', array(
            'form' => $form->createView(),
            'courses' => $courses
        ));
    }

    /**
     * @param Courses $courses
     * @param CoursesManager $coursesManager
     * @return Response
     *
     * @Route("/delete/{courses}", name="courses_delete", methods={"GET", "POST"})
     */
    public function deleteAction(Courses $courses, CoursesManager $coursesManager): Response
    {
        $coursesManager->delete($courses);
        $this->addFlash('success', "La matière ''" . $courses->getName() . "'' à bien été supprimée.");
        return $this->redirectToRoute('courses_index');
    }
}