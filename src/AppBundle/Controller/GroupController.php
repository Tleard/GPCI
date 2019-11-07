<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Group;
use AppBundle\Form\GroupType;
use AppBundle\Manager\GroupManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package AppBundle\Controlle
 *
 * @Route("/group")
 */
class GroupController extends Controller
{
    /**
     * Lists all booking entities.
     *
     * @Route("/", name="group_index", methods={"GET"})
     * @param GroupManager $groupManager
     * @return Response
     */
    public function indexAction(GroupManager $groupManager)
    {
        $groups = $groupManager->findAll();

        return $this->render(':admin:index.html.twig', array(
            'groups' => $groups
        ));
    }

    /**
     * @param Request $request
     * @param GroupManager $groupManager
     * @return Response
     *
     * @Route("/create", name="group_create", methods={"GET", "POST"})
     */
    public function newAction(Request $request, GroupManager $groupManager): Response
    {
        $group = new Group();
        $form = $this->createForm(GroupType::class, $group, array(
            'action' => $this->generateUrl('group_create')
        ));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $groupManager->createOrUpdate($group);
            $this->addFlash('success', "Le groupe ''" . $group->getName() . "'' à bien été crée.");
            return $this->redirectToRoute('group_index');
        }

        return $this->render('admin/new.html.twig', array(
            'form' => $form->createView(),
            'group' => $group
        ));
    }

    /**
     * @param Request $request
     * @param Group $group
     * @param GroupManager $groupManager
     * @return Response
     *
     * @Route("/edit/{group}", name="group_edit", methods={"GET", "POST"})
     */
    public function editAction(Request $request, Group $group, GroupManager $groupManager): Response
    {
        $form = $this->createForm(GroupType::class, $group, array(
            'action' => $this->generateUrl('group_edit', array(
                'group' => $group->getId()
            ))
        ));;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $groupManager->createOrUpdate($group);
            $this->addFlash('success', "Le groupe ''" . $group->getName() . "'' à bien été mis-à-jour.");
            return $this->redirectToRoute('admin_index');
        }

        return $this->render('admin/new.html.twig', array(
            'form' => $form->createView(),
            'group' => $group
        ));
    }

    /**
     * @param Group $group
     * @param GroupManager $groupManager
     * @return Response
     *
     * @Route("/delete/{group}", name="group_delete", methods={"GET", "POST"})
     */
    public function deleteAction(Group $group, GroupManager $groupManager): Response
    {
        $groupManager->delete($group);
        $this->addFlash('success', "Le groupe ''" . $group->getName() . "'' à bien été supprimé.");
        return $this->redirectToRoute('group_index');
    }
}
