<?php

namespace App\GalleryBundle\Controller;

use App\GalleryBundle\Repository\AlbumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AppGalleryBundle:Default:index.html.twig');
    }

    public function rpcGetAlbumsAction()
    {
        /** @var AlbumRepository $albumsRepository */
        $albumsRepository = $this->getDoctrine()->getRepository('AppGalleryBundle:Album');
        $albums = $albumsRepository->getAlbumsToView();

        return $this->render(
            'AppGalleryBundle:Default:rpcGet.html.twig',
            [
                'dataString' => json_encode($albums)
            ]
        );
    }

    public function rpcGetImagesAction(Request $request)
    {
        $albumId = $request->get('albumId');
        if (!$albumId) {
            throw new NotFoundHttpException("Album ID is not specified");
        }

        /** @var AlbumRepository $albumsRepository */
        $albumsRepository = $this->getDoctrine()->getRepository('AppGalleryBundle:Album');
        $album = $albumsRepository->getAlbumWithImages($albumId);

        if (!$album) {
            throw new NotFoundHttpException(
                sprintf("Not found album with ID %s", $albumId)
            );
        }

        $images = [];
        foreach ($album->getImages()->toArray() as $image) {
            $images[] = [
                'id' => $image->getId(),
                'src' => $image->getSrc(),
                'description' => $image->getDescription(),
            ];
        }

        return $this->render(
            'AppGalleryBundle:Default:rpcGet.html.twig',
            [
                'dataString' => json_encode($images)
            ]
        );
    }
}
