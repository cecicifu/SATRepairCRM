<?php

namespace App\Controller;

use App\Entity\Repair;
use App\Entity\RepairHasProducts;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DocumentController extends AbstractController
{
    private function generate(Repair $repair, string $html, string $type): Response
    {
        $options = new Options();
        $options->setIsRemoteEnabled(true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4');
        $dompdf->render();

        $filename = sprintf("%s - %s", $repair->getCode(), $type);

        $dompdf->stream($filename, [
            "Attachment" => true
        ]);

        return new Response(null, 200);
    }

    /**
     * @Route("/{id}/report", name="report")
     */
    public function report(Repair $repair): Response
    {
        $html = $this->renderView('document/report.html.twig', [
            'repair' => $repair
        ]);

        return $this->generate($repair, $html, 'report');
    }

    /**
     * @Route("/{id}/invoice", name="invoice")
     */
    public function invoice(Repair $repair): Response
    {
        $subtotal = 0;
        if(!$repair->getProducts()->isEmpty()) {

			/* @var RepairHasProducts $product */
            foreach ($repair->getProducts() as $product) {
                $subtotal += $product->getProduct()->getPrice() * $product->getQuantity();
            }
        }

        $totalWithoutTax = $subtotal + $repair->getLabourPrice();
        $totalTax = $totalWithoutTax * $repair->getTax();
        $total = $totalWithoutTax + $totalTax;

        $html = $this->renderView('document/invoice.html.twig', [
            'repair' => $repair,
            'subtotal' => $subtotal,
            'tax' => $repair->getTax() * 100,
            'total' => $total
        ]);

        return $this->generate($repair, $html, 'invoice');
    }
}