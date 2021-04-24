<?php

namespace App\Controller\Admin;

use App\Entity\Status;
use App\Form\StatusType;
use App\Repository\StatusRepository;
use DateTime;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatusController extends abstractController
{
    /**
     * @Route("/", name="status_index", methods={"GET"})
     * @param StatusRepository $statusRepository
     * @return Response
     */
    public function index(StatusRepository $statusRepository): Response
    {
        return $this->render('admin/status/index.html.twig', [
            'status' => $statusRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="status_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $status = new Status(Uuid::uuid4());
        $form = $this->createForm(StatusType::class, $status);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $status->setCreated(new DateTimeImmutable('now'));
            $status->setModified(new DateTime('now'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($status);
            $entityManager->flush();

            return $this->redirectToRoute('status_index');
        }

        return $this->render('admin/status/new.html.twig', [
            'status' => $status,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="status_show", methods={"GET"})
     * @param Status $status
     * @return Response
     */
    public function show(Status $status): Response
    {
        return $this->render('admin/status/show.html.twig', [
            'status' => $status,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="status_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Status $status
     * @return Response
     */
    public function edit(Request $request, Status $status): Response
    {
        $form = $this->createForm(StatusType::class, $status);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $status->setModified(new DateTime('now'));
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('status_index');
        }

        return $this->render('admin/status/edit.html.twig', [
            'status' => $status,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="status_delete", methods={"POST"})
     * @param Request $request
     * @param Status $status
     * @return Response
     */
    public function delete(Request $request, Status $status): Response
    {
        if ($this->isCsrfTokenValid('delete'.$status->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($status);
            $entityManager->flush();
        }

        return $this->redirectToRoute('status_index');
    }
}