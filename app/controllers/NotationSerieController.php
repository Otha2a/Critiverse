<?php

class NotationSerieController extends Controller
{
    public function index(): void
    {
        $this->render('notation-serie/index', ['title' => 'Notation S&eacute;rie - Critiverse']);
    }
}
