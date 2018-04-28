<?php

namespace App\Controller;

use App\Entity\CallSheet;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\CallSheetRepository;

class CallSheetController extends Controller
{
    /**
     * @Route("/api/checkIn", name="api_check_in", methods="POST")
     */
    public function checkIn(Request $request, CallSheetRepository $callSheetRepository): Response
    {
        $em = $this
            ->getDoctrine()
            ->getManager();
        $content = json_decode($request->getContent());
        if (!isset($content->QRCodeData) || empty($content->QRCodeData) || !is_string($content->QRCodeData)) {

            return $this->json(['error' => 'QRCode non fournis'], 422);
        }
        if (!isset($content->date) || empty($content->date) || !is_string($content->date)) {

            return $this->json(['error' => 'Date non fournis'], 422);
        }
        if (!isset($content->beaconCollection) || empty($content->beaconCollection) || !is_array($content->beaconCollection)) {

            return $this->json(['error' => 'Localisation non fournis'], 422);
        }
        if (!isset($content->Token) || empty($content->Token) || !is_string($content->Token)) {

            return $this->json(['error' => 'Token non fournis'], 422);
        }
        $user = key(unserialize(base64_decode($content->Token)));
        $result= $callSheetRepository->findEventNow(
            $content->QRCodeData,
            $user,
            $content->beaconCollection[2],
            $content->date
        );
        dump($result);
        if (!$result) {

            return $this->json(['Error' => 'Aucun résultat retourné, veuillez attendre le prochain QRCode'], 200);
        }
        $callSheet = $em
            ->getRepository(CallSheet::class)
            ->find($result->getId());
        if ($result->getEvent()->getDate() >= new \DateTime()) {
            $callSheet->setPresent(1);
        }else{
            $callSheet->setLate(1);
        }
        $em->persist($callSheet);
        $em->flush();

        return $this->json(['Success' => 'Réussi'], 200);
    }
}
