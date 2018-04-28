<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Location;
use App\Repository\CallSheetRepository;
use App\Repository\LocationRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Endroid\QrCode\QrCode;

class ApiController extends Controller
{
    /**
     * @Route("/", name="location", methods="GET")
     */
    public function index(LocationRepository $locationRepository): Response
    {
        return $this->render('location/index.html.twig', ['locations' => $locationRepository->findAll()]);
    }

    /**
     * @Route("/api/getLocation", name="get_location", methods="GET")
     */
    public function getLocation(Request $request, CallSheetRepository $callSheetRepository): Response
    {
        $token = base64_decode($request->headers->get('X-AUTH-TOKEN'));
        $userId = key(unserialize($token));
        $nowDate = new \DateTime();
        $currentDate = $nowDate->format('Y-m-d H:i:s');
        $eventObj = $callSheetRepository
            ->findLocationByUser($userId, $currentDate);
        $localisation = reset($eventObj)
            ->getEvent()
            ->getLocation()
            ->getDescription();
        $date = reset($eventObj)
            ->getEvent()
            ->getDate();

        return $this->json(['location' => $localisation, "date" => $date ], 200);
    }

    /**
     * @Route("/getQRCode", name="get_qrcode", methods="GET|POST")
     */
    public function qrCode(): Response
    {

        $qrLocation = (isset($_POST['location'])) ? $_POST['location'] : $_GET['id'];
        $em = $this
            ->getDoctrine()
            ->getManager();
        $location = $em
            ->getRepository(Location::class)
            ->find($qrLocation);
        $qrDescription = $location->getDescription();
        $qrString = $qrDescription."_".date("Ymd_His");
        $qrCode = new QrCode($qrString);
        $location->setQrCode($qrString);
        $em->persist($location);
        $em->flush();
        header('Content-Type: '.$qrCode->getContentType());
        header("Refresh:10 url=getQRCode?l=".$qrLocation);
        $qrCode->writeFile(__DIR__.'/../../public/img/qrcode.png');

        return $this->render('location/qrcode.html.twig');
    }

    /**
     * @Route("/api/login", name="user_login", methods="POST")
     */
    public function login(Request $request, UserRepository $userRepository): Response
    {
        $content = json_decode($request->getContent());
        if (!isset($content->Password) || empty($content->Password)) {

            return $this->json(['error' => 'Mot de passe requis'], 422);
        }
        if (!isset($content->Email) || empty($content->Email)) {

            return $this->json(['error' => 'Email requis'], 422);
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
    public function refreshToken(Request $request, UserRepository $userRepository): Response
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

        return $this->json(['token' => $token ], 200);
    }
}
