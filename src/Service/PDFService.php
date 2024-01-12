<?php

namespace App\Service;

use Dompdf\Dompdf;

class PDFService
{
    public function showPdfFile($html)
    {
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream("details.pdf", [
            'Attachement' => true
        ]);
    }


}