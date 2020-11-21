<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage", methods={"GET"})
     * @param ProjectRepository $projectRepository
     * @return Response
     */
    public function index(ProjectRepository $projectRepository) :Response
    {
        $projects = $projectRepository->findAllAndOrderByDatesDesc();

        return $this->render("home/index.html.twig", [
            "projects" => $projects,
        ]);
    }
}
