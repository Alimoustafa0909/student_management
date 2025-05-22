<?php
//Encapulate the class 
class Student
{
    private $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    // Get all students
    public function getAll($search = '')
    {
        $search = $this->conn->real_escape_string($search);
        $searchParam = "%$search%";
        $sql = "SELECT * FROM students WHERE name LIKE '$searchParam' OR id LIKE '$searchParam'";
        return $this->conn->query($sql);
    }

    // Get a student by ID
    public function getById($id)
    {
        $id = (int)$id;
        $sql = "SELECT * FROM students WHERE id = $id";
        $result = $this->conn->query($sql);
        return $result ? $result->fetch_assoc() : null;
    }

    // Add a new student
    public function create($name, $email, $gender, $phone)
    {
        $name = $this->conn->real_escape_string($name);
        $email = $this->conn->real_escape_string($email);
        $gender = $this->conn->real_escape_string($gender);
        $phone = $this->conn->real_escape_string($phone);

        $sql = "INSERT INTO students (name, email, gender, phone)
                VALUES ('$name', '$email', '$gender', '$phone')";

        return $this->conn->query($sql);
    }

    // Update student
    public function update($id, $name, $email, $gender, $phone)
    {
        $id = (int)$id;
        $name = $this->conn->real_escape_string($name);
        $email = $this->conn->real_escape_string($email);
        $gender = $this->conn->real_escape_string($gender);
        $phone = $this->conn->real_escape_string($phone);

        $sql = "UPDATE students
                SET name = '$name', email = '$email', gender = '$gender', phone = '$phone'
                WHERE id = $id";

        return $this->conn->query($sql);
    }

    // Delete student
    public function delete($id)
    {
        $id = (int)$id;
        $sql = "DELETE FROM students WHERE id = $id";
        return $this->conn->query($sql);
    }
}
