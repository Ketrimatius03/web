<?php

class Database
{
    private $conn;
    private $stmt;

    public function __construct()
    {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($this->conn->connect_error) {
            die('Database Connection Error: ' . $this->conn->connect_error);
        }
    }

    // ===============================
    // PREPARE QUERY
    // ===============================
    public function query($query)
    {
        $this->stmt = $this->conn->prepare($query);

        if (!$this->stmt) {
            die('Query Prepare Error: ' . $this->conn->error);
        }
    }

    // ===============================
    // BIND PARAMETER (SUPPORT MULTI)
    // ===============================
    public function bind($types, ...$values)
    {
        if (empty($values)) {
            return;
        }

        $this->stmt->bind_param($types, ...$values);
    }

    // ===============================
    // EXECUTE QUERY
    // ===============================
    public function execute()
    {
        if (!$this->stmt->execute()) {
            die('Query Execute Error: ' . $this->stmt->error);
        }
        return true;
    }

    // ===============================
    // AMBIL BANYAK DATA
    // ===============================
    public function resultSet()
    {
        $this->execute();
        $result = $this->stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // ===============================
    // AMBIL SATU DATA
    // ===============================
    public function single()
    {
        $this->execute();
        $result = $this->stmt->get_result();
        return $result->fetch_assoc();
    }

    // ===============================
    // HITUNG BARIS TERPENGARUH
    // ===============================
    public function rowCount()
    {
        return $this->stmt->affected_rows;
    }

    // ===============================
    // TUTUP STATEMENT (OPSIONAL)
    // ===============================
    public function close()
    {
        if ($this->stmt) {
            $this->stmt->close();
        }
    }
}
