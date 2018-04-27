<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\LocationRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Response\QrCodeResponse;
use Symfony\Component\HttpFoundation\Request;




class LocationController extends Controller
{
    /**
<<<<<<< HEAD
     * @Route("/api/location", name="location", methods="GET")
=======
     * @Route("/", name="location")
>>>>>>> 4b4db6b11a01b0ba6d8810e82224bf9fa23ae9c5
     */
    public function index(Request $request)
    {
<<<<<<< HEAD
        $location = $this->getDoctrine()->getRepository('App:Location')->find(1);
        return $this->json(['location' => $location]);
=======
        /*return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/LocationController.php',
        ]);*/

        return $this->render('location/index.html.twig', ['pastries' => $locationRepository->findAll()]);

        //$location = $this->getDoctrine()->getRepository('App:Location')->find(1);
        //return $this->json(['location' => $location]);

        /*$request = Request::createFromGlobals();
        echo $request->query->get('QRCodeData');
        if(true){
            $response = $this->json(['response' => 'OK']);
        }*/
    }
    /**
     * @Route("/api/checkIn", name="checkin")
     */
    public function checkin()
    {
        //$location = $this->getDoctrine()->getRepository('App:Location')->find(1);
        //return $this->json(['location' => $location]);

        $request = Request::createFromGlobals();
        $request->query->get('QRCodeData');
        if(true){
            $response = $this->json(['response' => $request]);
        }

        return $response;
    }
    /**
     * @Route("/getQRCode", name="getqrcode")
     */
    public function qrCode()
    {
        $qrLocation = 'Salle 7';
        $qrDate = date("Y-m-d H:i:s");
        $qrCode = new QrCode($qrLocation.$qrDate);

        header('Content-Type: '.$qrCode->getContentType());
        header("Refresh:10");
        $response = new QrCodeResponse($qrCode);

        return $response;
>>>>>>> 4b4db6b11a01b0ba6d8810e82224bf9fa23ae9c5
    }
}
