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
     * @Route("/", name="location", methods="GET")
     */
    public function index(LocationRepository $locationRepository)
    {
        return $this->render('location/index.html.twig', ['locations' => $locationRepository->findAll()]);
    }
    /**
     * @Route("/api/checkIn", name="checkin")
     */
    public function checkin()
    {
        //$location = $this->getDoctrine()->getRepository('App:Location')->find(1);
        //return $this->json(['location' => $location]);

        if(true){
            $response = $this->json(['response' => $request]);
        }

        return $response;
    }

    /**
     * @Route("/getQRCode", name="getqrcode", methods="POST")
     */
    public function qrCode()
    {
        $qrLocation = 'Salle 7';
        $qrString = $qrLocation.date("Y-m-d H:i:s");
        $qrCode = new QrCode($qrString);

        header('Content-Type: '.$qrCode->getContentType());
        header("Refresh:10");
        $qrCode->writeFile(__DIR__.'/../../public/img/qrcode.png');
        $response = new QrCodeResponse($qrCode);

        //return $response;
        return $this->render('location/qrcode.html.twig');
    }
}
