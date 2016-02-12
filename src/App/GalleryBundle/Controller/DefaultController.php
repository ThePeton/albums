<?php

namespace App\GalleryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AppGalleryBundle:Default:index.html.twig');
    }
}
