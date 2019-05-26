<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;

class RegistrationController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/register", name="api_register")
     * @param Request $request
     * @return View
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): View
    {

        $formData = json_decode($request->getContent(), true);

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);        

        if ($request->isMethod('POST')) {
            $form->submit($formData);

            if ($form->isSubmitted() && $form->isValid()) {
                // encode the plain password
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
                $user->setRoles(['ROLE_USER']);
                $user->setCreatedAt(date("Y-m-d H:i:s"));

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                // do anything else you need here, like send an email

                $data = ['id'=>$user->getId(), 'email'=>$user->getEmail(), 'fullName'=>$user->getFullName(), 'createdAt'=>$user->getCreatedAt()];

                return View::create($data, Response::HTTP_OK);

            }
        }

        $errors = $form->getErrors(true,false);
        return View::create($errors, Response::HTTP_NON_AUTHORITATIVE_INFORMATION);
    }

}
