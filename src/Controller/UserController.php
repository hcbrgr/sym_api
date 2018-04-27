<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends Controller
{

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
        $content = json_decode($request->getContent());
        if (!isset($content->Password) || empty($content->Password) || !isset($content->Email) || empty($content->Email)) {

            return $this->json(['error' => 'Champs requis'], 422);
        }
        $password= hash('sha512', $content->Password);
        $result = $userRepository->findByNameAndPass($content->Email, $password);
        if (!$result) {

            return $this->json(['error' => 'Identifiant ou mot de passe incorrect'], 400);
        }
        $token = base64_encode(serialize([
            $result->getId() => time()+20000
        ]));
        $result->setToken($token);
        $this->getDoctrine()->getManager()->flush();

        return $this->json(['token' => $token], 200);
    }

    /**
     * @Route("/api/refreshToken", name="refresh_token", methods="POST")
     */
    public function refreshToken(Request $request, UserRepository $userRepository)
    {
        $content = json_decode($request->getContent());
        if (!isset($content->token) || empty($content->token)) {

            return $this->json(['error' => 'Aucun token n\'a été envoyé.'], 422);
        }
        $test = unserialize(base64_decode($content->token));
        $token = base64_encode(serialize([
            key($test) => time()+20000
        ]));
        $user = $userRepository->find(key($test));
        $user->setToken($token);
        $this->getDoctrine()->getManager()->flush();
        //$user = $userRepository->find($jwt->user);
        //$user->setToken($newJwt);

        return $this->json(['token' => $token ], 200);
    }
}
