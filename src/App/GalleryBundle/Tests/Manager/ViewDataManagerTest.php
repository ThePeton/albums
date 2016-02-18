<?php

namespace App\GalleryBundle\Tests\Controller;

use App\GalleryBundle\Manager\Exception\AlbumNotFoundException;
use App\GalleryBundle\Manager\Exception\WrongPageNumberException;
use App\GalleryBundle\Manager\ViewDataManager;
use App\UnitTestBundle\AppDbTestCase;

class ViewDataManagerTest extends AppDbTestCase
{
    public function setUp(){
        $this->loadFixtures('src/App/GalleryBundle/DataFixtures/ORM/LoadDefaultData.php');

        $this->manager = $manager = new ViewDataManager(
            $this->getContainer()->get('doctrine'),
            $this->getContainer()->get('knp_paginator'),
            8,
            8
        );
    }

    public function testGetAlbumsWithPreviewImages()
    {
        $data = $this->manager->getAlbumsWithPreviewImages();
        $this->assertCount(5, $data);
        $this->assertCount(5, $data[0]['previewImages']);
        $this->assertCount(8, $data[1]['previewImages']);
    }

    public function testGetImagesByAlbumIdAndPage()
    {
        $this->assertEquals(1, $this->manager->getImagesByAlbumIdAndPage(1, 1)[0]['totalPages']);
        $this->assertCount(5, $this->manager->getImagesByAlbumIdAndPage(1, 1)[1]);

        $this->assertEquals(4, $this->manager->getImagesByAlbumIdAndPage(2, 1)[0]['totalPages']);
        $this->assertCount(1, $this->manager->getImagesByAlbumIdAndPage(2, 4)[1]);
    }

    public function testGetImagesByAlbumIdAndPageException1()
    {
        $this->setExpectedException(get_class(new AlbumNotFoundException()));
        $this->manager->getImagesByAlbumIdAndPage(6, 1);
    }

    public function testGetImagesByAlbumIdAndPageException2()
    {
        $this->setExpectedException(get_class(new WrongPageNumberException()));
        $this->manager->getImagesByAlbumIdAndPage(1, 2);
    }

    public function tearDown()
    {
        $this->truncate([
            'AppGalleryBundle:Image',
            'AppGalleryBundle:Album',
        ]);
    }
}