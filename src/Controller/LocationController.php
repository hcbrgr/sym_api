<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Location;
use App\Repository\CallSheetRepository;
use App\Repository\EventRepository;
use App\Repository\LocationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Response\QrCodeResponse;

class LocationController extends Controller
{

    /**
     * @Route("/api/getLocation", name="get_location", methods="GET")
     */
    public function getLocation(Request $request, CallSheetRepository $callSheetRepository, EventRepository $eventRepository, LocationRepository $locationRepository)
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
     * @Route("/", name="location", methods="GET")
     */
    public function index(LocationRepository $locationRepository)
    {
        return $this->render('location/index.html.twig', ['locations' => $locationRepository->findAll()]);
    }

    /**
     * @Route("/getQRCode", name="getqrcode", methods="GET|POST")
     */
    public function qrCode(LocationRepository $locationRepository)
    {
        if (isset($_POST['location'])) {
            $qrLocation = $_POST['location'];
        } else {
            $qrLocation = $_GET['l'];
        }

        $qrString = $qrLocation.date("Y-m-d H:i:s");
        $qrCode = new QrCode($qrString);

        $em = $this->getDoctrine()->getManager();
        $location = $em->getRepository(Location::class)->find($qrLocation);
        $location->setQrCode($qrString);
        $em->persist($location);
        $em->flush();


        header('Content-Type: '.$qrCode->getContentType());
        header("Refresh:10 url=getQRCode?l=".$qrLocation);
        $qrCode->writeFile(__DIR__.'/../../public/img/qrcode.png');
        $response = new QrCodeResponse($qrCode);

        //return $response;
        return $this->render('location/qrcode.html.twig');
    }
}
