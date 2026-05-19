<?php

class CritiquesController extends Controller
{
    public function index(): void
    {
        $this->render('critiques/index', ['title' => 'Critiques Populaires - Critiverse']);
    }
}
