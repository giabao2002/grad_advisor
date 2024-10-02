<?php
require_once("/xampp/htdocs/core/db_connect.php");

class StudentController
{
    private $conn;


    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function index($limit, $offset)
    {
        $query = "SELECT * FROM students LIMIT $limit OFFSET $offset";
        $result = mysqli_query($this->conn, $query);
        $students = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $students;
    }

    public function count()
    {
        $query = "SELECT COUNT(*) as total FROM students";
        $result = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    }

    public function store($data)
    {
        $fullname = $data['full_name'];
        $email = $data['email'];
        $student_code = $data['student_code'];
        $dob = $data['dob'];
        $major = $data['major'];
        $query = "INSERT INTO students (student_code,full_name, dob, major, email) VALUES ('$student_code','$fullname', '$dob', '$major', '$email')";
        if (mysqli_query($this->conn, $query)) {
            return true;
        } else {
            return false;
        }
    }

    public function update($id, $data)
    {
        $fullname = $data['full_name'];
        $email = $data['email'];
        $student_code = $data['student_code'];
        $dob = $data['dob'];
        $major = $data['major'];
        $query = "UPDATE students SET full_name='$fullname', email='$email', student_code='$student_code', dob='$dob', major='$major' WHERE id=$id";
        if (mysqli_query($this->conn, $query)) {
            return true;
        } else {
            return false;
        }
    }

    public function destroy($id)
    {
        $query = "DELETE FROM students WHERE id=$id";
        if (mysqli_query($this->conn, $query)) {
            return true;
        } else {
            return false;
        }
    }

    public function show($student_code) {
        $query = "SELECT * FROM students WHERE student_code ='$student_code'";
        $result = mysqli_query($this->conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $students = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $students;
        } else {
            return [];
        }
    }
}

// Khởi tạo controller
$studentController = new StudentController($conn);

// Xử lý các request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'store':
                $data = [
                    'student_code' => $_POST['student_code'],
                    'full_name' => $_POST['full_name'],
                    'email' => $_POST['email'],
                    'dob' => $_POST['dob'],
                    'major' => $_POST['major']
                ];
                $studentController->store($data);
                header("Location: /?page=students");
                break;
            case 'update':
                $id = $_POST['id'];
                $data = [
                    'student_code' => $_POST['student_code'],
                    'full_name' => $_POST['full_name'],
                    'email' => $_POST['email'],
                    'dob' => $_POST['dob'],
                    'major' => $_POST['major']
                ];
                $studentController->update($id, $data);
                header("Location: /?page=students");
                break;
            case 'destroy':
                $id = $_POST['id'];
                $studentController->destroy($id);
                header("Location: /?page=students");
                break;
        }
    }
}
//  elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
//     if (isset($_GET['action']) && $_GET['action'] === 'show') {
//         $search = $_GET['search'];
//         $students = $studentController->show($search);
//         // Hiển thị thông tin sinh viên
//     }
// }
