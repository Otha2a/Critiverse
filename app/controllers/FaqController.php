<?php

class FaqController extends Controller
{
    public function index(): void
    {
        $this->render('faq/index', ['title' => 'FAQ - Critiverse']);
    }
}
