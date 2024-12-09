<?php
require_once("/xampp/htdocs/core/db_connect.php");
require_once("/xampp/htdocs/core/SimpleXLSX.php");

use Shuchkin\SimpleXLSX;

class ProgressController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function index($limit, $offset, $major)
    {
        $query = "
            SELECT c.*
            FROM courses c
            JOIN majors m ON FIND_IN_SET(c.course_code, m.courses)
            WHERE m.major_code = '$major'
            LIMIT $offset, $limit
        ";
        $result = mysqli_query($this->conn, $query);
        $courses = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $courses;
    }

    public function count($major)
    {
        $query = "
            SELECT COUNT(*) as total
            FROM courses c
            JOIN majors m ON FIND_IN_SET(c.course_code, m.courses)
            WHERE m.major_code = '$major'
        ";
        $result = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    }

    public function search($search, $major)
    {
        $query = "
            SELECT c.*
            FROM courses c
            JOIN majors m ON FIND_IN_SET(c.course_code, m.courses)
            WHERE m.major_code = '$major' AND c.course_code LIKE '%$search%'
        ";
        $result = mysqli_query($this->conn, $query);
        $courses = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $courses;
    }

    public function destroy($data)
    {
        $course_code = $data['course_code'];
        $major_code = $data['major_code'];
        $query = "
            UPDATE majors 
            SET courses = TRIM(BOTH ',' FROM REPLACE(CONCAT(',', courses, ','), CONCAT(',', '$course_code', ','), ','))
            WHERE FIND_IN_SET('$course_code', courses) > 0 AND major_code = '$major_code'
        ";
        if (mysqli_query($this->conn, $query)) {
            return true;
        } else {
            return 'Xóa không thành công';
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
                $major_code = $row[1];
                $course_code = isset($row[3]) ? str_replace(' ', '', trim(mysqli_real_escape_string($this->conn, $row[3]))) : '';
                var_dump($course_code);
                if (strlen($course_code) > 0) {
                    $check_query = "SELECT * FROM majors WHERE major_code = '$major_code'";
                    $result = mysqli_query($this->conn, $check_query);

                    if (mysqli_num_rows($result) > 0) {
                        // major_code tồn tại, cập nhật cột courses
                        $row_data = mysqli_fetch_assoc($result);
                        $existing_courses = $row_data['courses'] ? json_decode($row_data['courses'], true) : [];

                        if (!in_array($course_code, $existing_courses)) {
                            $update_query = "UPDATE majors SET courses = '$course_code' WHERE major_code = '$major_code'";
                            if (mysqli_query($this->conn, $update_query)) {
                            }
                        }
                    } else {
                        // major_code không tồn tại
                        return "Mã ngành '$major_code' không tồn tại trong hệ thống, vui lòng kiểm tra lại!";
                    }
                }
            }
            return "Thêm học phần thành công!";
        } else {
            // Lỗi khi đọc file
            return "Lỗi khi đọc file Excel: " . SimpleXLSX::parseError();
        }
    }
}

$progressController = new ProgressController($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'destroy':
                $course_code = $_POST['course_code'];
                $major_code = $_POST['major_code'];
                $data = [
                    'course_code' => $course_code,
                    'major_code' => $major_code
                ];
                $message = $progressController->destroy($data);
                if (gettype($response) == "string") {
                    header("Location: /?page=progress&message=$message");
                } else {
                    header("Location: /?page=progress");
                }
                break;
            case 'import':
                if (isset($_FILES['data'])) {
                    $response = $progressController->import($_FILES['data']);
                    if (gettype($response) == "string") {
                        header("Location: /?page=progress&message=$response");
                    } else {
                        header("Location: /?page=progress");
                    }
                } else {
                    $response = "Tải file không thành công!";
                    header("Location: /?page=progress&message=$response");
                }
                break;
            default:
                break;
        }
    }  
}
