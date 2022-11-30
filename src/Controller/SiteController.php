<?php

declare(strict_types=1);

namespace App\Controller;
class SiteController extends AbstractController
{
    public function inicio(): void
    {
        $this->checkLogin();
        $this->render('home/inicio');
        $this->checkLogin();
    }    
}