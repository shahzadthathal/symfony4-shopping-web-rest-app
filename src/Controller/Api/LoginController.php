<?php

namespace App\Controller\Api;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Repository\UserRepository;


class LoginController extends AbstractFOSRestController
{
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Rest\Post("/login", name="api_login")
     * @param Request $request
     * @return View
     */
    public function login(Request $request, UserRepository $userRepository): View
    {

        $email = $request->request->get("email");
        $password = $request->request->get("password");

        if(empty($email) || empty($password)){
            $data['error']  = "Email and password fields are required";
            return View::create($data, Response::HTTP_NON_AUTHORITATIVE_INFORMATION);
        }

        $user = $userRepository->findOneByEmail($email);

        if($user === null){
            $data['error']  = "Account doesn't exist.";
            return View::create($data, Response::HTTP_NON_AUTHORITATIVE_INFORMATION);
        }

        if(!$this->passwordEncoder->isPasswordValid($user, $password)){
            $data['error']  = "Email or password doesn't match.";
            return View::create($data, Response::HTTP_NON_AUTHORITATIVE_INFORMATION);
        }

        if(empty($user->getApiToken)){
            $bytes = random_bytes(10);
            $apiToken = bin2hex($bytes).'-'.time();
            $user->setApiToken($apiToken);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $data['apikey'] = $user->getApiToken();
            return View::create($data, Response::HTTP_OK);
        }else{
            $data['apikey'] = $user->getApiToken();
            return View::create($data, Response::HTTP_OK);
        }


        return View::create([], Response::HTTP_NON_AUTHORITATIVE_INFORMATION);
    }

}
