<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\RegistrationType;
use AppBundle\Form\UserType;
use AppBundle\Manager\AdminManager;
use AppBundle\Manager\CoursesManager;
use AppBundle\Manager\GroupManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package AppBundle\Controlle
 *
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @param AdminManager $adminManager
     * @param GroupManager $groupManager
     * @param CoursesManager $coursesManager
     *
     * Lists all booking entities.
     *
     * @Route("/", name="admin_index", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function indexAction(AdminManager $adminManager, GroupManager $groupManager , CoursesManager $coursesManager)
    {
        $roles = $this->getUser()->getRoles();

        if (!in_array("ROLE_ADMIN", $roles)) {
             $this->addFlash(500, "This user is does not have the right to acces this page.");
             return $this->redirectToRoute('homepage');
        }

        $users = $adminManager->findAll();
        $groups = $groupManager->findAll();
        $courses = $coursesManager->findAll();

        return $this->render(':admin:index.html.twig', array(
            'users' => $users,
            'groups' => $groups,
            'courses' => $courses
        ));
    }

    /**
     * @param Request $request
     * @param AdminManager $adminManager
     * @return Response
     *
     * @Route("/create", name="admin_create", methods={"GET", "POST"})
     */
    public function newAction(Request $request, AdminManager $adminManager): Response
    {
        $roles = $this->getUser()->getRoles();

        if (!in_array("ROLE_ADMIN", $roles)) {
            /*Todo: Translation*/
            $this->addFlash(500, "This user is does not have the right to acces this page.");
            return $this->redirectToRoute('homepage');
        }

        $user = new User();
        $user->setEnabled(true);
        $form = $this->createForm(RegistrationType::class, $user, array(
            'action' => $this->generateUrl('admin_create')
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $adminManager->createOrUpdate($user);
            $this->addFlash('success', "L'utilisateur ''" . $user->getFirstName() . " " . $user->getLastName() . "'' à bien été crée.");
            return $this->redirectToRoute('admin_index');
        }

        return $this->render('admin/new_user.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));
    }

    /**
     * @param Request $request
     * @param User $user
     * @param AdminManager $adminManager
     * @return Response
     *
     * @Route("/edit/{user}", name="admin_edit", methods={"GET", "POST"})
     */
    public function editAction(Request $request, User $user, AdminManager $adminManager): Response
    {
        $roles = $this->getUser()->getRoles();

        if (!in_array("ROLE_ADMIN", $roles)) {
            /*Todo: Translation*/
            $this->addFlash(500, "This user is does not have the right to acces this page.");
            return $this->redirectToRoute('homepage');
        }

        $form = $this->createForm(RegistrationType::class, $user, array(
            'action' => $this->generateUrl('admin_edit', array(
                'user' => $user->getId()
            ))
        ));;
        $form->handleRequest($request);
        dump($user);

        if ($form->isSubmitted() && $form->isValid()) {
            $adminManager->createOrUpdate($user);
            $this->addFlash('success', "L'utilisateur ''" . $user->getFirstName() . " " . $user->getLastName() . "'' à bien été mis-à-jour.");
            return $this->redirectToRoute('admin_index');
        }

        return $this->render('admin/new_user.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));
    }

    /**
     * @param User $user
     * @param AdminManager $adminManager
     * @return Response
     *
     * @Route("/delete/{user}", name="admin_delete", methods={"GET", "POST"})
     */
    public function deleteAction(User $user, AdminManager $adminManager): Response
    {
        $roles = $this->getUser()->getRoles();

        if (!in_array("ROLE_ADMIN", $roles)) {
            /*Todo: Translation*/
            $this->addFlash("This user is does not have the right to acces this page.");
            return $this->redirectToRoute('homepage');
        }

        $adminManager->delete($user);
        $this->addFlash('success', "L'utilisateur ''" . $user->getFirstName() . " " . $user->getLastName() . "'' à bien été supprimé.");
        return $this->redirectToRoute('admin_index');
    }
}
