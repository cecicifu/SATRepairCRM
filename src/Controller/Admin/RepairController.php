<?php

namespace App\Controller\Admin;

use App\Entity\Repair;
use App\Form\RepairType;
use App\Repository\RepairRepository;
use DateTime;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
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
     * @param RepairRepository $repairRepository
     * @return Response
     */
    public function index(RepairRepository $repairRepository): Response
    {
        return $this->render('admin/repair/index.html.twig', [
            'repairs' => $repairRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="repair_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $repair = new Repair(Uuid::uuid4());
        $form = $this->createForm(RepairType::class, $repair);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $repair->setCode(uniqid());
            $repair->setModified(new DateTime('now'));
            $repair->setCreated(new DateTimeImmutable('now'));

            if (!$form->get('products')->getData()->isEmpty())  {
                $productsAdded = $form->get('products')->getData();

                foreach ($productsAdded as $productAdded) {
                    $productAdded->setRepair($repair);
                    $product = $productAdded->getProduct();

                    if ($product->getAmount() < $productAdded->getQuantity()) throw new Exception("Product {$product->getName()} amount not enough");
                    $product->setAmount($product->getAmount() - $productAdded->getQuantity());

                    $repair->addProduct($productAdded);

                    $entityManager->persist($product);
                }
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
     * @return Response
     */
    public function edit(Request $request, Repair $repair): Response
    {
        $form = $this->createForm(RepairType::class, $repair);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if(!$repair->getProducts()->isEmpty()) {
                foreach ($repair->getProducts() as $product) {
                    if ($product->getProduct()->getAmount() < $product->getQuantity()) throw new Exception("Product {$product->getProduct()->getName()} amount not enough");
                    $product->getProduct()->setAmount($product->getProduct()->getAmount() - $product->getQuantity());
                }
            }
            $repair->setModified(new DateTime('now'));

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
