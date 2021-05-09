<?php

namespace App\Controller\Admin;

use App\Entity\Repair;
use App\Form\RepairType;
use App\Service\RepairService;
use DateTime;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/repair")
 */
class RepairController extends AbstractController
{
    /**
     * @Route("/", name="repair_index", methods={"GET"})
     * @param RepairService $repairService
     * @return Response
     */
    public function index(RepairService $repairService): Response
    {
        return $this->render('admin/repair/index.html.twig', [
            'repairs' => $repairService->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="repair_new", methods={"GET","POST"})
     * @param Request $request
     * @param RepairService $repairService
     * @return Response
     */
    public function new(Request $request, RepairService $repairService): Response
    {
        $repair = new Repair(Uuid::uuid4(), "SR-".time(), true);
        $form = $this->createForm(RepairType::class, $repair);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $repair->setModified(new DateTime('now'));
            $repair->setCreated(new DateTimeImmutable('now'));

            if (!$form->get('products')->getData()->isEmpty())  {
                $repairService->updateRepairProductAmount($form->getData());
            }

            $entityManager->persist($repair);
            $entityManager->flush();

            return $this->redirectToRoute('repair_index');
        }

        return $this->render('admin/repair/new.html.twig', [
            'repair' => $repair,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="repair_show", methods={"GET"})
     * @param Repair $repair
     * @return Response
     */
    public function show(Repair $repair): Response
    {
        return $this->render('admin/repair/show.html.twig', [
            'repair' => $repair,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="repair_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Repair $repair
     * @param RepairService $repairService
     * @return Response
     */
    public function edit(Request $request, Repair $repair, RepairService $repairService): Response
    {
        $form = $this->createForm(RepairType::class, $repair);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repair->setModified(new DateTime('now'));

            if(!$repair->getProducts()->isEmpty()) {
                $repairService->updateRepairProductAmount($repair);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('repair_index');
        }

        return $this->render('admin/repair/edit.html.twig', [
            'repair' => $repair,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="repair_delete", methods={"POST"})
     * @param Request $request
     * @param Repair $repair
     * @return Response
     */
    public function delete(Request $request, Repair $repair): Response
    {
        if ($this->isCsrfTokenValid('delete'.$repair->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($repair);
            $entityManager->flush();
        }

        return $this->redirectToRoute('repair_index');
    }
}
