<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Form\Type\TaskRegistrationType;
use AppBundle\Form\Model\TaskRegistration;


class TaskController extends Controller
{
    /**
     * @Route("/task/register", name="task_register")
     */
    public function taskRegisterAction()
    {
        $registration = new TaskRegistration();

        $form = $this->createForm(new TaskRegistrationType(), $registration, array(
            'action' => $this->generateUrl('task_create'),
        ));

        return $this->render(
            'AppBundle:Task:register.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/task/create", name="task_create")
     */
    public function taskCreateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new TaskRegistrationType(), new TaskRegistration());

        $form->handleRequest($request);

        if ($form->isValid()) {
            // get registration data
            $registration = $form->getData();

            // get user
            $user = $this->getUser();

            // get task
            $task = $registration->getTask();

            // set user to task
            $task->setUser($user);

            $em->persist($task);
            $em->flush();

            // set flash message
            // ToDo

            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render(
            'AppBundle:Task:register.html.twig',
            array('form' => $form->createView())
        );
    }
}