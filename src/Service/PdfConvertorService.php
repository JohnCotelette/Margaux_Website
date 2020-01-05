<?php

namespace App\Service;

use Spipu\Html2Pdf\Html2Pdf;

/**
 * Class PdfConvertorService
 * @package App\Service
 */
class PdfConvertorService {
    /**
     * @var Html2Pdf
     */
    private $html2Pdf;

    /**
     * PdfConvertorService constructor.
     * @param Html2Pdf $html2pdf
     */
    public function __construct(Html2Pdf $html2pdf)
    {
        $this->html2Pdf = $html2pdf;
    }

    /**
     * @param string $template
     * @param string $name
     * @return string
     */
    public function generatePdf(string $template, string $name)
    {
        $this->html2Pdf->writeHTML($template);

        return $this->html2Pdf->output($name . ".pdf");
    }
}