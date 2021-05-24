<?php

namespace App\Controller;

use App\Form\TrackerType;
use App\Service\RepairService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrackerController extends AbstractController
{
    /**
     * @Route("/", name="tracker_index")
     */
    public function index(): Response
    {
        $form = $this->createForm(TrackerType::class);

        return $this->render('tracker/index.html.twig', [
            'controller_name' => 'TrackerController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/tracker", name="tracker_search")
     */
    public function search(Request $request, RepairService $repairService): Response
    {
        if ($request->isXmlHttpRequest()) {
            $repair = $repairService->findByCode($request->getContent());

            if ($repair && $repair->isVisible()) {
                return new JsonResponse([
                    'category' => $repair->getCategory()->getName(),
                    'status' => $repair->getStatus()->getName(),
                    'status_color' => $repair->getStatus()->getColour(),
                    'code' => $repair->getCode(),
                    'fault' => $repair->getFault(),
                    'colour' => $repair->getColour(),
                    'publicComment' => $repair->getPublicComment(),
                    'created' => $repair->getCreated()->format('Y-m-d'),
                ], 200);
            }

            return new JsonResponse(null, 404);
        }

        return new JsonResponse(null, 400);
    }
}
