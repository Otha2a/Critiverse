<?php

class NotationFilmController extends Controller
{
    public function index(): void
    {
        $this->render('notation-film/index', ['title' => 'Notation Film - Critiverse']);
    }
}
