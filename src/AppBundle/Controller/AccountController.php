<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Form\Type\UserRegistrationType;
use AppBundle\Form\Model\UserRegistration;
use AppBundle\Form\Type\FamilyRegistrationType;
use AppBundle\Form\Model\FamilyRegistration;
use AppBundle\Form\Type\FamilyJoinType;

class AccountController extends Controller
{
    /**
     * @Route("/register/user", name="user_register")
     */
    public function userRegisterAction()
    {
        $registration = new UserRegistration();

        $form = $this->createForm(new UserRegistrationType(), $registration, array(
            'action' => $this->generateUrl('user_create'),
        ));

        return $this->render(
            'AppBundle:Account:register.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/register/user/create", name="user_create")
     */
    public function userCreateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new UserRegistrationType(), new UserRegistration());

        $form->handleRequest($request);

        if ($form->isValid()) {
            // get registration data
            $registration = $form->getData();

            // get user
            $user = $registration->getUser();

            // encode password
            $plainPassword = $user->getPassword();
            
            $encoded = $this->container->get('security.password_encoder')
                ->encodePassword($user, $plainPassword);

            $user->setPassword($encoded);

            $em->persist($user);
            $em->flush();

            // set flash message
            // ToDo

            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render(
            'AppBundle:Account:register.html.twig',
            array('form' => $form->createView())
        );
    }
}