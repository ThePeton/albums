<?php

namespace App\GalleryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AppGalleryBundle:Default:index.html.twig');
    }

    public function rpcGetImagesAction(){
        $result = [];

        for ($i = 1; $i <= 20; $i++){
            $result[] = [
                'id' => $i,
                'src' => '/upload/gallery/'.$i.'.jpg',
                'text' => 'Some text '.$i
            ];
        }

        return $this->render(
            'AppGalleryBundle:Default:rpcGet.html.twig',
            [
                'dataString' => json_encode($result)
            ]
        );
    }

    public function rpcGetAlbumsAction(){
        $result = [];

        for ($i = 1; $i <= 5; $i++){
            $result[] = [
                'id' => $i,
                'name' => 'Album name '.$i,
                'description' => 'Album '.$i.' middle size description'
            ];
        }

        return $this->render(
            'AppGalleryBundle:Default:rpcGet.html.twig',
            [
                'dataString' => json_encode($result)
            ]
        );
    }
}
