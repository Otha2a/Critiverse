<?php

class NotationController extends Controller
{
    public function index(): void
    {
        $this->render('notation/index', ['title' => 'Notation - Critiverse']);
    }
}
