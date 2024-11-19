<?php
require_once("/xampp/htdocs/core/db_connect.php");
require_once("/xampp/htdocs/core/SimpleXLSX.php");

use Shuchkin\SimpleXLSX;


class GradeController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function index($limit, $offset, $course)
    {
        $query = "
            SELECT s.full_name, g.*, JSON_UNQUOTE(JSON_EXTRACT(g.grade, '$.\"$course\"')) AS course_grade 
            FROM grades g 
            LEFT JOIN students s ON g.student_code = s.student_code 
            WHERE JSON_CONTAINS_PATH(g.grade, 'one', '$.\"$course\"') 
            LIMIT $offset, $limit
        ";
        $result = mysqli_query($this->conn, $query);
        $grades = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $grades;
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
        $student_code = $data['student_code'];
        $courses = $data['courses'];
        $grades = $data['grades'];

        $student_query = "SELECT * FROM students WHERE student_code = '$student_code'";
        $student_result = mysqli_query($this->conn, $student_query);

        if (mysqli_num_rows($student_result) == 0) {
            return "Mã sinh viên không tồn tại";
        }

        // Tạo mảng để lưu điểm dưới dạng JSON
        $grades_json = [];
        foreach ($courses as $index => $course_id) {
            $grades_json[$course_id] = $grades[$index];
        }
        $grades_json = json_encode($grades_json);

        // Kiểm tra xem sinh viên đã có trong danh sách hay chưa
        $check_query = "
            SELECT 
                g.student_code, 
                JSON_UNQUOTE(JSON_EXTRACT(g.grade, CONCAT('$.\"', c.course_code, '\"'))) AS course_grade,
                c.course_code,
                c.course_name
            FROM grades g
            JOIN courses c ON JSON_CONTAINS_PATH(g.grade, 'one', CONCAT('$.\"', c.course_code, '\"'))
            WHERE g.student_code = '$student_code'
        ";
        $check_result = mysqli_query($this->conn, $check_query);

        if ($check_result) {
            $existing_grades = [];
            while ($row = mysqli_fetch_assoc($check_result)) {
                $existing_grades[$row['course_code']] = $row['course_grade'];
            }

            foreach ($courses as $index => $course_id) {
                if (isset($existing_grades[$course_id])) {
                    // Nếu đã có điểm cho học phần này, bỏ qua việc thêm hoặc cập nhật
                    return "Điểm cho học phần đã có, không thể sửa!";
                }

                // Nếu chưa có điểm cho học phần này, thêm hoặc cập nhật điểm
                $update_query = "
                    UPDATE grades 
                    SET grade = JSON_SET(grade, '$.\"$course_id\"', '$grades[$index]') 
                    WHERE student_code = '$student_code'
                ";
                if (!mysqli_query($this->conn, $update_query)) {
                    return "Lỗi khi cập nhật điểm cho sinh viên";
                }
            }

            // Nếu không có học phần nào cần cập nhật, trả về thông báo
            if (empty($existing_grades)) {
                $insert_query = "INSERT INTO grades (student_code, grade) VALUES ('$student_code', '$grades_json')";
                if (!mysqli_query($this->conn, $insert_query)) {
                    return "Lỗi khi thêm điểm cho sinh viên";
                }
            }
        }

        return true;
    }

    public function destroy($id, $course)
    {
        $check_query = "
        SELECT JSON_LENGTH(grade) AS num_courses 
        FROM grades 
        WHERE id = $id
        ";
        $check_result = mysqli_query($this->conn, $check_query);
        $row = mysqli_fetch_assoc($check_result);

        if ($row['num_courses'] == 1) {
            //Nếu chỉ có 1 học phần thì xóa cả
            $delete_query = "DELETE FROM grades WHERE id = $id";
            if (mysqli_query($this->conn, $delete_query)) {
                return true;
            } else {
                return "Xóa không thành công!";
            }
        } else {
            //Nếu không phải học phần duy nhất, chỉ xóa học phần và điểm của nó
            $update_query = "
            UPDATE grades 
            SET grade = JSON_REMOVE(grade, '$.\"$course\"') 
            WHERE id = $id
            ";
            if (mysqli_query($this->conn, $update_query)) {
                return true;
            } else {
                return "Xóa học phần thất bại!";
            }
        }
    }

    public function search($search, $course_code)
    {
        $query = "
        SELECT s.full_name, g.*, JSON_UNQUOTE(JSON_EXTRACT(g.grade, '$.\"$course_code\"')) AS course_grade 
        FROM grades g 
        LEFT JOIN students s ON g.student_code = s.student_code
        WHERE 
        g.student_code = '$search' AND
        JSON_CONTAINS_PATH(grade, 'one', '$.\"$course_code\"')
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
            $course_code = [];

            // Duyệt qua các hàng, bỏ qua hàng đầu tiên nếu là tiêu đề
            foreach ($xlsx->rows() as $index => $row) {
                if ($index < 5) continue;

                // Lấy mã học phần từ hàng thứ 5
                if ($index == 5) {
                    $col = 3;
                    while ($row[$col]) {
                        $result = preg_replace('/\s*\(\d+\)$/', '', $row[$col]);
                        $course_code[] = $result;
                        $col += 2;
                    }
                }
                // Bắt đầu lấy điểm từ hàng thứ 10
                if($index > 9 ){
                    $studentCode = $row[1] ?? null;
                    $grades = [];
                    $col = 4;
                    for($i = 0; $i < count($course_code); $i++){
                        $grades[] = $row[$col] ?? null;
                        $col += 2;
                    }
                    if ($studentCode) {
                        $this->store([
                            'student_code' => $studentCode,
                            'courses' => $course_code,
                            'grades' => $grades,
                        ]);
                    }
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
$gradeController = new GradeController($conn);

// Xử lý các request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'store':
                $data = [
                    'student_code' => $_POST['student_code'],
                    'courses' => $_POST['courses'],
                    'grades' => $_POST['grades']
                ];
                $response = $gradeController->store($data);
                if (gettype($response) == "string") {
                    header("Location: /?page=grades&message=$response");
                } else {
                    header("Location: /?page=grades");
                }
                break;
            case 'destroy':
                $id = $_POST['id'];
                $course = $_POST['course'];
                $res = $gradeController->destroy($id, $course);
                if (gettype($response) == "string") {
                    header("Location: /?page=grades&message=$response");
                } else {
                    header("Location: /?page=grades");
                }
                break;
            case 'import':
                if (isset($_FILES['data'])) {
                    $response = $gradeController->import($_FILES['data']);
                    if (gettype($response) == "string") {
                        header("Location: /?page=grades&message=$response");
                    } else {
                        header("Location: /?page=grades");
                    }
                } else {
                    $response = "Tải file không thành công!";
                    header("Location: /?page=grades&message=$response");
                }
                break;
        }
    }
}
