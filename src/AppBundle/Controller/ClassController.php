<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\Manager\AdminManager;
use AppBundle\Manager\ClassManager;
use AppBundle\Manager\GroupManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ClassController
 * @package AppBundle\Controlle
 *
 * @Route("/class")
 */
class ClassController extends Controller
{
    /**
     * @param Request $request
     * @param ClassManager $classManager
     * @return Response
     *
     * @Route("/create", name="class_create", methods={"GET", "POST"})
     */
    public function newAction(Request $request, ClassManager $classManager): Response
    {
        $roles = $this->getUser()->getRoles();

        if (!in_array("ROLE_ADMIN", $roles)) {
            /*Todo: Translation*/
            $this->addFlash("This user is does not have the right to acces this page.");
            return $this->redirectToRoute('admin_index');
        }

        $user = new User();
        $form = $this->createForm(UserType::class, $user, array(
            'action' => $this->generateUrl('class_create')
        ));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $classManager->createOrUpdate($user);
            $this->addFlash('success', "La matiére ''" . $user->getFirstName() . " " . $user->getLastName() . "'' à bien été crée.");
            return $this->redirectToRoute('admin_index');
        }

        return $this->render('class/new_user.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));
    }
}
