<?php

class Controller
{
    protected function view($view, $data = [])
    {
        extract($data);
        require_once ROOT . '/App/views/' . $view . '.php';
    }

    protected function model($model)
    {
        require_once ROOT . '/App/models/' . $model . '.php';
        return new $model;
    }

    protected function auth($roles = null)
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }

        if ($roles) {
            $roles = (array)$roles;
            if (!in_array($_SESSION['user']['role'], $roles)) {
                die('Akses ditolak');
            }
        }
    }
}
