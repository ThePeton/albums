<?php

namespace App\GalleryBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\GalleryBundle\Entity\Album;
use App\GalleryBundle\Entity\Image;

class LoadDefaultData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $albums = [];
        $counter = 1;
        foreach ($this->getAlbumsData() as $item){
            $album = new Album();
            $album->setName($item[0])
                ->setDescription($item[1]);

            $manager->persist($album);

            $albums[$counter] = $album;
            $counter++;
        }

        foreach ($this->getImagesData() as $item) {
            $image = new Image();
            $image->setAlbum($albums[$item[0]])
                ->setSrc($item[1])
                ->setDescription($item[2]);

            $manager->persist($image);
        }

        $manager->flush();
    }

    private function getAlbumsData()
    {
        return [
            ['Nature', 'Some photos about nature'],
            ['Space', 'Some photos about space'],
            ['Earth', 'Some photos about earth'],
            ['Science', 'Some photos about science'],
            ['Future', 'Some photos about future'],
        ];
    }

    private function getImagesData()
    {
        $counter = 1;

        $images = [];
        for ($i = 0; $i < 5; $i++) {
            $images[] = [1, '/upload/gallery/'.$counter.'.jpg', 'Some text '.$counter];
            $counter++;
        }

        for ($albumRef = 2; $albumRef <= 5; $albumRef++) {
            for ($i = 0; $i < 25; $i++) {
                $images[] = [$albumRef, '/upload/gallery/'.$counter.'.jpg', 'Some text '.$counter];
                $counter++;
            }
        }

        return $images;
    }
}