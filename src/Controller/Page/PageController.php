<?php

namespace App\Controller\Page;

use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class PageController extends AbstractController
{
    /**
     * @Route("/", name="homepage", methods={"GET"})
     * @param ProjectRepository $projectRepository
     * @return Response
     */
    public function home(ProjectRepository $projectRepository) :Response
    {
        $projects = $projectRepository->findAllAndOrderByDatesDesc();

        return $this->render("home/index.html.twig", [
            "projects" => $projects,
        ]);
    }

    /**
     * @Route("/about", name="about", methods={"GET"})
     * @return Response
     */
    public function about() :Response
    {
        return $this->render("about/index.html.twig");
    }
}