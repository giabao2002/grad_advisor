<?php
require_once("/xampp/htdocs/core/db_connect.php");
require_once("/xampp/htdocs/core/SimpleXLSX.php");

use Shuchkin\SimpleXLSX;

class StudentController
{
    private $conn;


    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function index($limit = PHP_INT_MAX, $offset = 0)
    {
        $query = "SELECT * FROM students LIMIT $offset, $limit";
        $result = mysqli_query($this->conn, $query);

        $students = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $students[] = $row;
        }

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
        $identity = $data['identity'];
        $address = $data['address'];
        $gender = $data['gender'];
        $dob = $data['dob'];
        $major = $data['major'];
        $query = "INSERT INTO students (student_code,full_name, dob, email, identity, address, gender, major) VALUES ('$student_code','$fullname', '$dob', '$email', '$identity', '$address', '$gender', '$major')";
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
        $identity = $data['identity'];
        $address = $data['address'];
        $gender = $data['gender'];
        $dob = $data['dob'];
        $query = "UPDATE students SET full_name='$fullname', email='$email', student_code='$student_code', dob='$dob', identity='$identity', address='$address', gender='$gender' WHERE id=$id";
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

    public function show($student_code)
    {
        $query = "SELECT * FROM students WHERE student_code ='$student_code'";
        $result = mysqli_query($this->conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $students = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $students;
        } else {
            return [];
        }
    }

    public function import($file)
    {
        // Kiểm tra phần mở rộng của file
        $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $valid_extensions = ['xlsx'];
        if (!in_array($file_extension, $valid_extensions)) {
            return "File không hợp lệ! Chỉ chấp nhận các file có định dạng .xlsx.";
        }

        // Kiểm tra loại MIME của file
        $file_mime = mime_content_type($file['tmp_name']);
        $valid_mimes = [
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ];
        if (!in_array($file_mime, $valid_mimes)) {
            return "File không hợp lệ! Chỉ chấp nhận các file có định dạng .xlsx.";
        }

        if ($xlsx = SimpleXLSX::parse($file['tmp_name'])) {
            foreach ($xlsx->rows() as $index => $row) {
                if ($index < 2) continue;
                // Bắt đầu lấy thông tin sinh viên
                $student_code = $row[1];
                $fullname = $row[2] . " " . $row[3];
                $gender = $row[4];
                $dob = $row[5];
                $address = $row[6];
                $identity = $row[7];
                $status = $row[8];
                $email = $row[9];
                $major = $row[10];

                $dob_date = DateTime::createFromFormat('d/m/Y', $dob);
                if ($dob_date) {
                    $dob = $dob_date->format('Y-m-d');
                } else {
                    $dob = null;
                }

                if (strlen($student_code) >= 8) {
                    $this->store([
                        'student_code' => $student_code,
                        'full_name' => $fullname,
                        'email' => $email,
                        'identity' => $identity,
                        'address' => $address,
                        'gender' => $gender,
                        'dob' => $dob,
                        'status' => $status,
                        'major' => $major
                    ]);
                }
            }
            return "Thêm thành công!";
        } else {
            // Lỗi khi đọc file
            return "Lỗi khi đọc file Excel: " . SimpleXLSX::parseError();
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
                    'identity' => $_POST['identity'],
                    'address' => $_POST['address'],
                    'gender' => $_POST['gender'],
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
                    'identity' => $_POST['identity'],
                    'address' => $_POST['address'],
                    'gender' => $_POST['gender'],
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
            case 'import':
                if (isset($_FILES['data'])) {
                    $response = $studentController->import($_FILES['data']);
                    if (gettype($response) == "string") {
                        header("Location: /?page=students&message=$response");
                    } else {
                        header("Location: /?page=students");
                    }
                } else {
                    $response = "Tải file không thành công!";
                    header("Location: /?page=students&message=$response");
                }
                break;
        }
    }
}
