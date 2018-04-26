<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\LocationRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LocationController extends Controller
{
    /**
     * @Route("/location", name="location")
     */
    public function index(LocationRepository $locationRepository)
    {
        /*return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/LocationController.php',
        ]);*/
        $location = $this->getDoctrine()->getRepository('App:Location')->find(1);
        return $this->json(['location' => $location]);
    }
}
