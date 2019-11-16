<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\Manager\AdminManager;
use AppBundle\Manager\GroupManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @package AppBundle\Controller
 *
 * @route("/user")
 */
Class UserController extends Controller {


    /**
     * Lists all Users
     *
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function indexAction()
    {
        $roles = $this->getUser()->getRoles();

        $users = $adminManager->findAll();
        $groups = $groupManager->findAll();

        return $this->render(':user:index.html.twig', array(
            'users' => $users,
            'groups' => $groups
        ));
    }
}
