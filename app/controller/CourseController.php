<?php
require_once("/xampp/htdocs/core/db_connect.php");

class CourseController
{
    private $conn;


    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function index($limit, $offset)
    {
        $query = "SELECT c.*, pre_c.course_name AS pre_course_name FROM courses c LEFT JOIN courses pre_c ON c.pre_course = pre_c.id LIMIT $limit OFFSET $offset";
        $result = mysqli_query($this->conn, $query);
        $courese = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $courese;
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
        $semester = $data['semester'] ? $data['semester'] : null;
        $year = $data['year'] ? $data['year'] : null;
        $pre_course = $data['pre_course'] ? $data['pre_course'] : null;

        // Kiểm tra xem môn học đã tồn tại hay chưa
        $check_query = "SELECT * FROM courses WHERE course_code = '$course_code' OR course_name = '$course_name'";
        $result = mysqli_query($this->conn, $check_query);

        if (mysqli_num_rows($result) > 0) {
            // Môn học đã tồn tại
            return "Môn học đã tồn tại";
        } else {
            if (!empty($pre_course)) {
                $pre_course_query = "SELECT * FROM courses WHERE id = '$pre_course'";
                $pre_course_result = mysqli_query($this->conn, $pre_course_query);

                if (mysqli_num_rows($pre_course_result) == 0) {
                    // pre_course không tồn tại
                    return "Môn học tiên quyết không tồn tại";
                }
            }
            // Thêm mới môn học
            if ($pre_course == null) {
                $query = "INSERT INTO courses (course_code, course_name, credits, semester, year) VALUES ('$course_code', '$course_name', '$credits', '$semester', '$year')";
            } else {
                $query = "INSERT INTO courses (course_code, course_name, credits, semester, year, pre_course) VALUES ('$course_code', '$course_name', '$credits', '$semester', '$year', '$pre_course')";
            }
            if (mysqli_query($this->conn, $query)) {
                return true;
            } else {
                return "Thêm môn học thất bại";
            }
        }
    }

    public function update($id, $data)
    {
        $course_name = $data['course_name'];
        $course_code = $data['course_code'];
        $credits = $data['credits'];
        $semester = $data['semester'] ? $data['semester'] : null;
        $year = $data['year'] ? $data['year'] : null;
        $pre_course = $data['pre_course'] ? $data['pre_course'] : null;

        if (!empty($pre_course)) {
            $pre_course_query = "SELECT * FROM courses WHERE id = '$pre_course'";
            $pre_course_result = mysqli_query($this->conn, $pre_course_query);

            if (mysqli_num_rows($pre_course_result) == 0) {
                // pre_course không tồn tại
                return "Môn học tiên quyết không tồn tại";
            }
        }
        // Cập nhật thông tin môn học
        if ($pre_course == null) {
            $query = "UPDATE courses SET course_code='$course_code', course_name='$course_name', credits='$credits', semester='$semester', year='$year' WHERE id=$id";
        } else {
            $query = "UPDATE courses SET course_code='$course_code', course_name='$course_name', credits='$credits', semester='$semester', year='$year', pre_course='$pre_course' WHERE id=$id";
        }
        if (mysqli_query($this->conn, $query)) {
            return true;
        } else {
            return "Chỉnh sửa thông tin môn học thất bại";
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
                    'semester' => $_POST['semester'],
                    'year' => $_POST['year'],
                    'pre_course' => $_POST['pre_course']
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
                    'semester' => $_POST['semester'],
                    'year' => $_POST['year'],
                    'pre_course' => $_POST['pre_course']
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
        }
    }
}
