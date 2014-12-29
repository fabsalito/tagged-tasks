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

            // get family
            $family = $registration->getFamily();

            // get family repository
            $repository = $this->getDoctrine()
                ->getRepository('AppBundle:Family');

            // try get family from database
            $familyDb = $repository->findOneByFamilyName($family->getFamilyName());

            // if exists family in database
            if (null != $familyDb) {
                // set the database objecto for user
                $family = $familyDb;

                // ask for join family or select other family name
                // ToDo
            }

            // set family to user
            $user->setFamily($family);

            $em->persist($user);
            $em->persist($family);
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

    /**
     * @Route("/register/family", name="family_register")
     */
    public function familyRegisterAction()
    {
        $registration = new FamilyRegistration();
        $form = $this->createForm(new FamilyRegistrationType(), $registration, array(
            'action' => $this->generateUrl('family_create'),
        ));

        return $this->render(
            'AppBundle:Account:register.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/register/family/create", name="family_create")
     */
    public function familyCreateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new FamilyRegistrationType(), new FamilyRegistration());

        $form->handleRequest($request);

        if ($form->isValid()) {
            $registration = $form->getData();

            $em->persist($registration->getUser());
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

    /**
     * @Route("/register/family/join", name="family_join")
     */
    public function familyJoinAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new FamilyJoinType(), new FamilyRegistration());

        $form->handleRequest($request);

        if ($form->isValid()) {
            $registration = $form->getData();

            $em->persist($registration->getUser());
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