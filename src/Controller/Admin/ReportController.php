<?php

namespace App\Controller\Admin;

use App\Entity\Repair;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReportController extends AbstractController {

    /**
     * @Route("/{id}/report", name="report")
     */
    public function generate(Repair $repair): Response
    {
        $options = new Options();
        $options->setIsRemoteEnabled(true);

        $dompdf = new Dompdf($options);

        $html = $this->renderView('admin/pdf/report.html.twig', [
            'repair' => $repair
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4');
        $dompdf->render();

        $dompdf->stream($repair->getCode(), [
            "Attachment" => true
        ]);

        return new Response(null, 200);
    }
}