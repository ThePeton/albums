<?php

namespace App\GalleryBundle\Controller;

use App\GalleryBundle\Repository\AlbumRepository;
use App\GalleryBundle\Repository\ImageRepository;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Knp\Component\Pager\Paginator;
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
        $albumsData = $albumsRepository->getAlbumWithImages();

        $result = [];
        foreach ($albumsData as $albumObj) {
            $albumArr = [
                'id' => $albumObj->getId(),
                'name' => $albumObj->getName(),
                'description' => $albumObj->getDescription(),
            ];

            $counter = 1;
            foreach ($albumObj->getImages() as $image) {
                $albumArr['previewImages'][] = $image->getSrc();;

                if ($counter++ >= 10) {
                    break;
                }
            }

            $result[] = $albumArr;
        }

        return $this->render(
            'AppGalleryBundle:Default:rpcGet.html.twig',
            [
                'dataString' => $result
            ]
        );
    }

    public function rpcGetImagesAction(Request $request)
    {
        $albumId = $request->query->getInt('albumId');
        $page = $request->query->getInt('page', 1);
        $onPage = $request->query->getInt('onPage', 10);

        if (!$albumId) {
            throw new NotFoundHttpException("Album ID is not specified");
        }

        /** @var AlbumRepository $albumsRepository */
        $albumsRepository = $this->getDoctrine()->getRepository('AppGalleryBundle:Album');
        $album = $albumsRepository->getAlbumWithImages($albumId);

        if (!$album) {
            throw new NotFoundHttpException(
                sprintf("Album with ID %s not found", $albumId)
            );
        }


        /** @var ImageRepository $albumsRepository */
        $imagesRepository = $this->getDoctrine()->getRepository('AppGalleryBundle:Image');
        $imagesQuery = $imagesRepository->getQueryForPaginatorByAlbumId($albumId);

        /** @var Paginator $paginator */
        $paginator  = $this->get('knp_paginator');

        /** @var SlidingPagination $pagination */
        $pagination = $paginator->paginate(
            $imagesQuery,
            $page,
            $onPage
        );

        if ($pagination->getPageCount() < $page) {
            throw new NotFoundHttpException(
                sprintf("Album page %s not found", $page)
            );
        }

        $images = [];
        foreach ($pagination as $image) {
            $images[] = [
                'id' => $image->getId(),
                'src' => $image->getSrc(),
                'description' => $image->getDescription(),
            ];
        }

        $data = [
            [
                'total' => $pagination->getTotalItemCount(),
                'pageCount' => $pagination->getPageCount(),
                'page' =>$pagination->getCurrentPageNumber()
            ],
            $images
        ];

        return $this->render(
            'AppGalleryBundle:Default:rpcGet.html.twig',
            [
                'dataString' => $data
            ]
        );
    }
}
