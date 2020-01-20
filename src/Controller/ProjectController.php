<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/project")
 * @isGranted("ROLE_ADMIN")
 */
class ProjectController extends AbstractController
{
    /**
     * @Route("s", name="projects_index", methods={"GET"})
     * @param ProjectRepository $projectRepository
     * @return Response
     */
    public function index(ProjectRepository $projectRepository): Response
    {
        $projects = $projectRepository->findAllAndOrderByDatesDesc();

        return $this->render("project/index.html.twig", [
            "projects" => $projects,
        ]);
    }

    /**
     * @Route("/new", name="project_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $project = new Project();

        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this
                ->getDoctrine()
                ->getManager();

            $em->persist($project);
            $em->flush();

            return $this->redirectToRoute("projects_index");
        }

        return $this->render("project/new.html.twig", [
            "project" => $project,
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="project_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Project $project
     * @return Response
     */
    public function edit(Request $request, Project $project): Response
    {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this
                ->getDoctrine()
                ->getManager()
                ->flush();

            return $this->redirectToRoute("projects_index");
        }

        return $this->render("project/edit.html.twig", [
            "project" => $project,
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="project_delete", methods={"DELETE"})
     * @param Request $request
     * @param Project $project
     * @return Response
     */
    public function delete(Request $request, Project $project): Response
    {
        if ($this->isCsrfTokenValid("delete".$project->getId(), $request->request->get("_token"))) {
            $em = $this
                ->getDoctrine()
                ->getManager();

            $em->remove($project);
            $em->flush();
        }

        return $this->redirectToRoute("projects_index");
    }
}
