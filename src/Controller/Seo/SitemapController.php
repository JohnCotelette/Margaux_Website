<?php

namespace App\Controller\Seo;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SitemapController extends AbstractController
{
    /**
     * @var array
     */
    private $urls = [];

    /**
     * @Route("/sitemap.xml", name="sitemap", defaults={"_format"="xml"}, methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $hostname = $request->getSchemeAndHttpHost();

        $this->urls[] = ["loc" => $this->generateUrl("homepage")];
        $this->urls[] = ["loc" => $this->generateUrl("about")];

        $response = new Response(
            $this->renderView("sitemap/index.html.twig", [
                "urls" => $this->urls,
                "hostname" => $hostname
            ]),
            200
        );

        $response->headers->set("Content-Type", "text/xml");

        return $response;
    }
}