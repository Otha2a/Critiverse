<?php

class SeriesController extends Controller
{
    public function index(): void
    {
        $this->render('series/index', ['title' => 'Séries - Critiverse']);
    }
}
