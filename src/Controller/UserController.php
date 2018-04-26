<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Routing\Annotation\Route;
use Firebase\JWT\JWT;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends Controller
{
    /**
     * @Route("/user", name="user", methods="GET")
     */
    public function index(): Response
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->json(['user' => $users], 200);
    }

    /**
     * @Route("/login", name="user_login", methods="POST")
     */
    public function login(Request $request, UserRepository $userRepository): Response
    {
        $log = json_decode($request->getContent());
        $password= hash('sha512', $log->password);
        $result = $userRepository->findByNameAndPass($log->name, $password);
        if (!$result) {

            return $this->json(['error' => 'Identifiant ou mot de passe incorrect'], 404);
        }
        $key = 'key';
        $token = array(
            "iat" => time(),
            "nbf" => time()+20000,
            "user" => $result
        );
        //A revoir
        $jwt = JWT::encode($token, $key);

        return $this->json(['token' => $jwt], 200);
    }
}
