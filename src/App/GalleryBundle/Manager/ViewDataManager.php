<?php

namespace App\GalleryBundle\Manager;

use App\GalleryBundle\Repository\AlbumRepository;
use App\GalleryBundle\Repository\ImageRepository;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Knp\Component\Pager\Pagination\SlidingPagination;
use Knp\Component\Pager\Paginator;

class ViewDataManager
{
    /**
     * @var Registry
     */
    private $doctrine;

    /**
     * @var Paginator
     */
    private $paginator;

    /**
     * @var integer
     */
    private $previewImagesNumber;

    /**
     * @var integer
     */
    private $imagesPerPage;


    /**
     * @param Registry $doctrine
     * @param Paginator $paginator
     * @param integer $previewImagesNumber
     * @param integer $imagesPerPage
     */
    public function __construct(Registry $doctrine, Paginator $paginator, $previewImagesNumber, $imagesPerPage)
    {
        $this->doctrine = $doctrine;
        $this->paginator = $paginator;
        $this->previewImagesNumber = $previewImagesNumber;
        $this->imagesPerPage = $imagesPerPage;
    }

    /**
     * Get album data as array with a list of preview images limited by configuration
     * @return array
     */
    public function getAlbumsWithPreviewImages()
    {
        /** @var AlbumRepository $albumsRepository */
        $albumsRepository = $this->doctrine->getRepository('AppGalleryBundle:Album');
        $albumsData = $albumsRepository->getAlbumsAsArray();

        /** @var ImageRepository $imagesRepository */
        $imagesRepository = $this->doctrine->getRepository('AppGalleryBundle:Image');

        foreach ($albumsData as &$album) {
            $images = $imagesRepository->getImagesSrcByAlbumIdAndLimit($album['id'], $this->previewImagesNumber);
            foreach ($images as $image) {
                $album['previewImages'][] = $image['src'];
            }
        }

        return $albumsData;
    }

    public function getImagesByAlbumIdAndPage($albumId, $page)
    {
        /** @var ImageRepository $albumsRepository */
        $imagesRepository = $this->doctrine->getRepository('AppGalleryBundle:Image');
        $imagesQuery = $imagesRepository->getQueryForPaginatorByAlbumId($albumId);

        /** @var SlidingPagination $pagination */
        $pagination = $this->paginator->paginate(
            $imagesQuery,
            $page,
            $this->imagesPerPage
        );

        $images = [];
        foreach ($pagination as $image) {
            $images[] = [
                'id' => $image->getId(),
                'src' => $image->getSrc(),
                'description' => $image->getDescription(),
            ];
        }

        return [
            [
                'total' => $pagination->getTotalItemCount(),
                'pageCount' => $pagination->getPageCount(),
                'page' => $pagination->getCurrentPageNumber(),
                'onPage' => $this->imagesPerPage
            ],
            $images
        ];
    }
}
