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
     * Key for JWT
     * @var string
     */
    const KEY = 'key';

    /**
     * @Route("/api/user", name="user", methods="GET")
     */
    public function index(): Response
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->json(['user' => $users], 200);
    }

    /**
     * @Route("/api/login", name="user_login", methods="POST")
     */
    public function login(Request $request, UserRepository $userRepository): Response
    {
        $log = json_decode($request->getContent());
        $password= hash('sha512', $log->Password);
        $result = $userRepository->findByNameAndPass($log->Email, $password);
        if (!$result) {

            return $this->json(['error' => 'Identifiant ou mot de passe incorrect'], 400);
        }
        $token = array(
            "iat" => time(),
            "nbf" => time()+20000,
            "user" => reset($result)->getId()
        );
        //A revoir
        $jwt = JWT::encode($token, self::KEY);
        $test = JWT::decode($jwt, self::KEY, ['HS256']);

        return $this->json(['token' => $jwt], 200);
    }

    /**
     * @Route("/api/refreshToken", name="refresh_token", methods="POST")
     */
    public function refreshToken(Request $request)
    {
        $content = json_decode($request->getContent());
        if (!isset($content->token) || empty($content->token)) {

            return $this->json(['error' => 'Aucun token n\'a été envoyé.'], 422);
        }
        $jwt = JWT::decode($content->token, self::KEY, ['HS256']);
        $token = array(
            "iat" => time(),
            "nbf" => time()+20000,
            "user" => $jwt->user
        );
        //A revoir
        $newJwt = JWT::encode($token, self::KEY);

        return $this->json(['token' => $newJwt], 200);
    }
}
