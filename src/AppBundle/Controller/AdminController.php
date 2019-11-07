<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\Manager\AdminManager;
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
     * Lists all booking entities.
     *
     * @Route("/", name="admin_index", methods={"GET"})
     */
    public function indexAction(AdminManager $adminManager)
    {
        $users = $adminManager->findAll();

        return $this->render(':admin:index.html.twig', array(
            'users' => $users
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
        $user = new User();
        $form = $this->createForm(UserType::class, $user, array(
            'action' => $this->generateUrl('admin_create')
        ));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $adminManager->createOrUpdate($user);
            $this->addFlash('success', "L'utilisateur ''" . $user->getFirstName() . " " . $user->getLastName() . "'' à bien été crée.");
            return $this->redirectToRoute('admin_index');
        }

        return $this->render('admin/new.html.twig', array(
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
        $form = $this->createForm(UserType::class, $user, array(
            'action' => $this->generateUrl('admin_edit', array(
                'user' => $user->getId()
            ))
        ));;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $adminManager->createOrUpdate($user);
            $this->addFlash('success', "L'utilisateur ''" . $user->getFirstName() . " " . $user->getLastName() . "'' à bien été mis-à-jour.");
            return $this->redirectToRoute('admin_index');
        }

        return $this->render('admin/new.html.twig', array(
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
        $adminManager->delete($user);
        $this->addFlash('success', "L'utilisateur ''" . $user->getFirstName() . " " . $user->getLastName() . "'' à bien été supprimé.");
        return $this->redirectToRoute('admin_index');
    }
}
