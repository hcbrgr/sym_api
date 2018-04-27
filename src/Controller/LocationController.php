<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\LocationRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Response\QrCodeResponse;




class LocationController extends Controller
{
    /**
     * @Route("/api/location", name="location", methods="GET")
     */
    public function index(Request $request)
    {
        return true;
    }
    /**
     * @Route("/api/checkIn", name="checkin")

    public function checkin()
    {
        //$location = $this->getDoctrine()->getRepository('App:Location')->find(1);
        //return $this->json(['location' => $location]);

        if(true){
            $response = $this->json(['response' => $request]);
        }

        return $response;
    }*/

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
    }
}
