<?php

class Users
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // ambil user berdasarkan username
    public function getUserByUsername($username)
    {
        $this->db->query("SELECT * FROM user WHERE username = ?");
        $this->db->bind('s', $username);
        return $this->db->single();
    }

    // register user
    public function register($data)
    {
        $this->db->query("
            INSERT INTO user 
            (nama_user, username, password, role, no_hp, email, status)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        $this->db->bind(
            'sssssss',
            $data['nama_user'],
            $data['username'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['role'],
            $data['no_hp'],
            $data['email'],
            'aktif'
        );

        return $this->db->execute();
    }

    // update password
    public function updatePassword($id, $password)
    {
        $this->db->query("UPDATE user SET password = ? WHERE id_user = ?");
        $this->db->bind('si', $password, $id);
        return $this->db->execute();
    }
}
