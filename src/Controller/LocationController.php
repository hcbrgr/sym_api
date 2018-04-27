<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\LocationRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LocationController extends Controller
{
    /**
     * @Route("/api/location", name="location", methods="GET")
     */
    public function index(Request $request)
    {
        $location = $this->getDoctrine()->getRepository('App:Location')->find(1);
        return $this->json(['location' => $location]);
    }
}
