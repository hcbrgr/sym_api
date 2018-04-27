<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CallSheetController extends Controller
{
    /**
     * @Route("/api/checkIn", name="api_check_in", methods="POST")
     */
    public function checkIn(Request $request): Response
    {
        /*$content = json_decode($request->getContent());
        if(
            !isset($content->QRCodeData) || empty($content->QRCodeData) ||
            !isset($content->date) || empty($content->date) ||
            !isset($content->beaconCollection) || empty($content->beaconCollection) ||
            !isset($content->beaconCollection) || empty($content->)
        )*/
    }
}
