<?php

namespace App\GalleryBundle\Tests\Controller;

use App\UnitTestBundle\AppDbTestCase;
use App\UnitTestBundle\AppTestCase;

class DefaultControllerTest extends AppDbTestCase
{
    public function setUp(){
        $this->loadFixtures('src/App/GalleryBundle/DataFixtures/ORM/LoadDefaultData.php');
    }

    /**
     * @dataProvider urlSuccessProvider
     */
    public function testPagesReturnCode($url)
    {
        $client = static::createClient();
        $client->request('GET', $url);
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function urlSuccessProvider()
    {
        return [
            ['/'],
            ['/album/1'],
            ['/album/2/page/2'],
            ['gallery/albums/rpc/']
        ];
    }

    /**
     * @dataProvider urlErrorProvider
     */
    public function testErrorPages($url)
    {
        $client = static::createClient();
        $client->request('GET', $url);
        $this->assertTrue($client->getResponse()->isNotFound());
    }

    public function urlErrorProvider()
    {
        return [
            ['/album/7'],
            ['/album/1/2'],
        ];
    }

    public function tearDown()
    {
        $this->truncate([
            'AppGalleryBundle:Image',
            'AppGalleryBundle:Album',
        ]);
    }
}
