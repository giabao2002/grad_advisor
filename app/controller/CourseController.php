<?php
require_once("/xampp/htdocs/core/db_connect.php");
require_once("/xampp/htdocs/core/SimpleXLSX.php");

use Shuchkin\SimpleXLSX;

class CourseController
{
    private $conn;


    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function index($limit, $offset)
    {
        $query = "SELECT c.*, pre_c.course_name AS pre_course_name FROM courses c LEFT JOIN courses pre_c ON c.pre_course = pre_c.course_code" . (($limit !== null && $offset !== null) ? " LIMIT $limit OFFSET $offset" : "");
        $result = mysqli_query($this->conn, $query);
        $courses = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $courses;
    }

    public function count()
    {
        $query = "SELECT COUNT(*) as total FROM courses";
        $result = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    }

    public function store($data)
    {
        $course_name = $data['course_name'];
        $course_code = $data['course_code'];
        $credits = $data['credits'];
        $optional = $data['optional'] ? $data['optional'] : null;
        $pre_course = $data['pre_course'] ? $data['pre_course'] : null;
        $accumulation = $data['accumulation'] ? $data['accumulation'] : null;

        // Kiểm tra xem học phần đã tồn tại hay chưa
        $check_query = "SELECT * FROM courses WHERE course_code = '$course_code' OR course_name = '$course_name'";
        $result = mysqli_query($this->conn, $check_query);

        if (mysqli_num_rows($result) > 0) {
            // học phần đã tồn tại
            return "học phần đã tồn tại";
        } else {
            if (!empty($pre_course)) {
                $pre_course_query = "SELECT * FROM courses WHERE course_code = '$pre_course'";
                $pre_course_result = mysqli_query($this->conn, $pre_course_query);

                if (mysqli_num_rows($pre_course_result) == 0) {
                    // pre_course không tồn tại
                    return "Học phần tiên quyết không tồn tại, vui lòng thêm mới hoặc chỉnh sửa lại sau!";
                }
            }
            // Thêm mới học phần
            if ($pre_course == null) {
                $query = "INSERT INTO courses (course_code, course_name, credits, optional, accumulation) VALUES ('$course_code', '$course_name', '$credits', '$optional', '$accumulation')";
            } else {
                $query = "INSERT INTO courses (course_code, course_name, credits, optional, pre_course, accumulation) VALUES ('$course_code', '$course_name', '$credits', '$optional', '$pre_course', '$accumulation')";
            }
            if (mysqli_query($this->conn, $query)) {
                return true;
            } else {
                return "Thêm học phần thất bại";
            }
        }
    }

    public function update($id, $data)
    {
        $course_name = $data['course_name'];
        $course_code = $data['course_code'];
        $credits = $data['credits'];
        $optional = $data['optional'] ? $data['optional'] : null;
        $pre_course = $data['pre_course'] ? $data['pre_course'] : null;
        $accumulation = $data['accumulation'] ? $data['accumulation'] : null;

        if (!empty($pre_course)) {
            $pre_course_query = "SELECT * FROM courses WHERE course = '$pre_course'";
            $pre_course_result = mysqli_query($this->conn, $pre_course_query);

            if (mysqli_num_rows($pre_course_result) == 0) {
                // pre_course không tồn tại
                return "Học phần tiên quyết không tồn tại";
            }
        }
        // Cập nhật thông tin học phần
        if ($pre_course == null) {
            $query = "UPDATE courses SET course_code='$course_code', course_name='$course_name', credits='$credits', optional='$optional', accumulation='$accumulation' WHERE id=$id";
        } else {
            $query = "UPDATE courses SET course_code='$course_code', course_name='$course_name', credits='$credits', optional='$optional', pre_course='$pre_course', accumulation='$accumulation' WHERE id=$id";
        }
        if (mysqli_query($this->conn, $query)) {
            return true;
        } else {
            return "Chỉnh sửa thông tin học phần thất bại";
        }
    }

    public function destroy($id)
    {
        $query = "DELETE FROM courses WHERE id=$id";
        if (mysqli_query($this->conn, $query)) {
            return true;
        } else {
            return false;
        }
    }

    public function search($search, $search_by)
    {
        $query = "
            SELECT c.*, pre_c.course_name AS pre_course_name
            FROM courses c
            LEFT JOIN courses pre_c ON c.pre_course = pre_c.id
            WHERE c.$search_by = '$search'
        ";

        $result = mysqli_query($this->conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $courses = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $courses;
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
                if ($index < 1) continue;
                $course_code = $row[1];
                $course_name = $row[2];
                $credits = $row[3];
                $optional = strlen($row[4]) > 0 ? 'Bắt buộc' : 'Tự chọn';
                $pre_course = $row[6];

                if (strlen($course_code) > 0) {
                    $this->store([
                        'course_code' => $course_code,
                        'course_name' => $course_name,
                        'credits' => $credits,
                        'optional' => $optional,
                        'pre_course' => $pre_course,
                        'accumulation' => 0
                    ]);
                }
            }
            return "Thêm điểm thành công!";
        } else {
            // Lỗi khi đọc file
            return "Lỗi khi đọc file Excel: " . SimpleXLSX::parseError();
        }
    }
}

// Khởi tạo controller
$courseController = new CourseController($conn);

// Xử lý các request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'store':
                $data = [
                    'course_code' => $_POST['course_code'],
                    'course_name' => $_POST['course_name'],
                    'credits' => $_POST['credits'],
                    'optional' => $_POST['optional'],
                    'pre_course' => $_POST['pre_course'],
                    'accumulation' => $_POST['accumulation']
                ];
                $response = $courseController->store($data);
                if (gettype($response) == "string") {
                    header("Location: /?page=courses&message=$response");
                } else {
                    header("Location: /?page=courses");
                }
                break;
            case 'update':
                $id = $_POST['id'];
                $data = [
                    'course_code' => $_POST['course_code'],
                    'course_name' => $_POST['course_name'],
                    'credits' => $_POST['credits'],
                    'optional' => $_POST['optional'],
                    'pre_course' => $_POST['pre_course'],
                    'accumulation' => $_POST['accumulation']
                ];
                $response = $courseController->update($id, $data);
                if (gettype($response) == "string") {
                    header("Location: /?page=courses&message=$response");
                } else {
                    header("Location: /?page=courses");
                }
                break;
            case 'destroy':
                $id = $_POST['id'];
                $courseController->destroy($id);
                header("Location: /?page=courses");
                break;
            case 'import':
                if (isset($_FILES['data'])) {
                    $response = $courseController->import($_FILES['data']);
                    if (gettype($response) == "string") {
                        header("Location: /?page=courses&message=$response");
                    } else {
                        header("Location: /?page=courses");
                    }
                } else {
                    $response = "Tải file không thành công!";
                    header("Location: /?page=courses&message=$response");
                }
                break;
        }
    }
}
