<?php

class AuthController extends Controller
{
    public function index()
    {
        header('Location: ' . BASEURL . '/auth/login');
        exit;
    }

    public function login()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $username = $_POST['username'];
        $password = $_POST['password'];

        $user = $this->model('Users')->getUserByUsername($username);

        if (!$user) {
            die('USER TIDAK DITEMUKAN');
        }

    
        if (
            password_verify($password, $user['password']) ||
            $password === $user['password']
        ) {

            // kalau password masih polos → auto hash
            if ($password === $user['password']) {
                $this->model('Users')->updatePassword(
                    $user['id_user'],
                    password_hash($password, PASSWORD_DEFAULT)
                );
            }

            $_SESSION['user'] = [
                'id'       => $user['id_user'],
                'username' => $user['username'],
                'role'     => $user['role']
            ];

            if ($user['role'] === 'admin') {
                header('Location: ' . BASEURL . '/dashboard/admin');
            } else {
                header('Location: ' . BASEURL . '/dashboard/petugas');
            }
            exit;
        }

        die('PASSWORD SALAH');

    } else {
        $this->view('auth/login');
    }
}
}