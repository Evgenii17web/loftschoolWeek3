<?php
namespace App\Controller;

use App\Model\User;
use Base\AbstractController;

class Login extends AbstractController
{
    public function index()
    {
        if ($this->getUser()) {
            $this->redirect('/blog');
        }
        return $this->view->render(
            'login.phtml',
            [
                'title' => 'Главная',
                'user' => $this->getUser(),
            ]
        );
    }

    public function auth()
    {
        $email = (string) $_POST['email'];
        $password = (string) $_POST['password'];

        $user = User::getByEmail($email);
        if (!$user) {
            return 'Неверный логин и пароль';
        }

        if ($user->getPassword() !== User::getPasswordHash($password)) {
            return 'Неверный логин и пароль';
        }

        $this->session->authUser($user->getId());

        $this->redirect('/blog');
    }

    public function register()
    {
        $name = (string) $_POST['name'];
        $email = (string) $_POST['email'];
        $password = (string) $_POST['password'];
        $password2 = (string) $_POST['password_2'];

        if (!$name || !$password) {
            return ERROR_NAME_AND_PASSWORD;
        }

        if (!$email) {
            return ERROR_EMAIL;
        }

        if ($password !== $password2) {
            return ERROR_MISMATCH_PASSWORD;
        }

        if (mb_strlen($password) < 5) {
            return ERROR_SHORT_PASSWORD;
        }

        $userData = [
            'name' => $name,
            'created_at' => date('Y-m-d H:i:s'),
            'password' => $password,
            'email' => $email,
        ];
        $user = new User($userData);
        $user->save();

        $this->session->authUser($user->getId());
        $this->redirect('/blog');
    }
}