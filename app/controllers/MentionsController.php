<?php

class MentionsController extends Controller
{
    public function index(): void
    {
        $this->render('mentions/index', ['title' => 'Mentions légales - Critiverse']);
    }
}
