<?php

class FilmsController extends Controller
{
    public function index(): void
    {
        $this->render('films/index', ['title' => 'Films - Critiverse']);
    }
}
