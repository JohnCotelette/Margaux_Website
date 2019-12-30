<?php

namespace App\Controller\Api;

use App\Repository\PictureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/")
 */
class ApiController extends AbstractController {
    /**
     * @Route("projects/{id}/pictures", name="API_get_project_pictures", requirements={"id"="\d+"}, methods={"GET"})
     * @param PictureRepository $pictureRepository
     * @param int $id
     * @return JsonResponse
     */
    public function getProjectPicturesLinks(PictureRepository $pictureRepository, int $id) {
        $pictures = $pictureRepository
            ->findBy(["project" => $id]);

        if (!$pictures) {
            return new JsonResponse(
                ["message" => "The project doesn't exist or doesn't have any pictures."],
                Response::HTTP_NOT_FOUND
            );
        }

        $picturesLinks = [];

        forEach($pictures as $picture) {
            $picturesLinks[] = $picture->getName();
        }

        return new JsonResponse(
            ["picturesLinks" => $picturesLinks],
            Response::HTTP_OK
        );
    }
}
