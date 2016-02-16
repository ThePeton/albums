<?php

namespace App\GalleryBundle\Controller;

use App\GalleryBundle\Manager\ViewDataManager;
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
        /** @var ViewDataManager $dataManager */
        $dataManager = $this->get('app_gallery.view_data_manager');
        return $this->render(
            'AppGalleryBundle:Default:rpcGet.html.twig',
            [
                'dataString' => $dataManager->getAlbumsWithPreviewImages()
            ]
        );
    }

    public function rpcGetImagesAction(Request $request)
    {
        $albumId = $request->query->getInt('albumId');
        $page = $request->query->getInt('page', 1);

        if (!$albumId) {
            throw new NotFoundHttpException("Album ID is not specified");
        }

        /** @var AlbumRepository $albumsRepository */
        $albumsRepository = $this->getDoctrine()->getRepository('AppGalleryBundle:Album');
        $album = $albumsRepository->getAlbumById($albumId);

        if (!$album) {
            throw new NotFoundHttpException(
                sprintf("Album with ID %s not found", $albumId)
            );
        }

        $dataManager = $this->get('app_gallery.view_data_manager');
        $result = $dataManager->getImagesByAlbumIdAndPage($albumId, $page);

        if ($result[0]['pageCount'] < $page) {
            throw new NotFoundHttpException(
                sprintf("Album page %s not found", $page)
            );
        }

        return $this->render(
            'AppGalleryBundle:Default:rpcGet.html.twig',
            [
                'dataString' => $result
            ]
        );
    }
}
