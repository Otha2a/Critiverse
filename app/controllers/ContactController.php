<?php
// Gère le formulaire de contact

class ContactController extends Controller
{
    public function index(): void
    {
        $this->render('contact/form', ['title' => 'Contact - Critiverse']);
    }

    public function send(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/contact');
            return;
        }

        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $message = $_POST['message'] ?? '';

        if (empty($name) || empty($email) || empty($message)) {
            $this->redirect('/Critiverse/public/contact?error=validation');
            return;
        }

        $db = new Database();
        if ($db->insertContact($name, $email, $message)) {
            $this->redirect('/Critiverse/public/contact?success=1');
        } else {
            $this->redirect('/Critiverse/public/contact?error=db');
        }
    }
}