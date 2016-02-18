<?php

namespace App\GalleryBundle\Controller;

use App\GalleryBundle\Manager\Exception\AlbumNotFoundException;
use App\GalleryBundle\Manager\Exception\WrongPageNumberException;
use App\GalleryBundle\Manager\ViewDataManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    public function indexAction($format = '')
    {
        /** @var ViewDataManager $dataManager */
        $dataManager = $this->get('app_gallery.view_data_manager');
        $result = $dataManager->getAlbumsWithPreviewImages();

        if ($format == 'json') {
            return $this->render(
                'AppGalleryBundle:Default:rpcGet.html.twig',
                ['dataString' => $result]
            );
        } else {
            return $this->render(
                'AppGalleryBundle:Default:index.html.twig',
                ['albumsData' => $result]
            );
        }
    }

    public function imagesAction($albumId, $page, Request $request, $format = '')
    {
        if ($format == 'json') {
            $albumId = $request->query->getInt('albumId');
            $page = $request->query->getInt('page', 1);
        }

        /** @var ViewDataManager $dataManager */
        $dataManager = $this->get('app_gallery.view_data_manager');

        try {
            $result = $dataManager->getImagesByAlbumIdAndPage($albumId, $page);
        } catch (AlbumNotFoundException $ex) {
            throw new NotFoundHttpException(
                sprintf("Album with ID %s not found", $albumId)
            );
        } catch (WrongPageNumberException $ex) {
            throw new NotFoundHttpException(
                sprintf("Album page %s not found", $page)
            );
        }

        if ($format == 'json') {
            return $this->render(
                'AppGalleryBundle:Default:rpcGet.html.twig',
                ['dataString' => $result]
            );
        } else {
            return $this->render(
                'AppGalleryBundle:Default:index.html.twig',
                ['imagesData' => $result]
            );
        }
    }
}
