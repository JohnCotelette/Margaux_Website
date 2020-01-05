<?php

namespace App\Controller;

use App\Service\PdfConvertorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController
{
    /**
     * @Route("/about", name="about", methods={"GET"})
     * @param PdfConvertorService $pdfConvertorService
     * @return string
     */
    public function index(PdfConvertorService $pdfConvertorService)
    {
        $template = $this->renderView("pdf/about.html.twig", []);

        $pdfConvertorService->generatePdf();

        return $pdfConvertorService->generatePdf($template, "MargauxCV");
    }
}