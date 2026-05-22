<?php

class AnimesController extends Controller
{
    public function index(): void
    {
        $this->render('animes/index', ['title' => 'Animes - Critiverse']);
    }
}
