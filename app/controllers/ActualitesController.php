<?php

class ActualitesController extends Controller
{
    public function index(): void
    {
        $this->render('actualites/index', ['title' => 'Actualités - Critiverse']);
    }
}
