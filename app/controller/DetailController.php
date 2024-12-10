<?php
require_once "./core/db_connect.php";

class DetailController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    function index($student_code)
    {
        // Ngăn chặn SQL Injection
        $student_code = mysqli_real_escape_string($this->conn, $student_code);

        // Query lấy thông tin sinh viên và điểm
        $query = "
    SELECT 
        s.*, 
        g.grade AS grades, 
        g.language as language,
        g.infomatic as infomatic,
        g.military as military,
        g.practising as practising
    FROM students s 
    LEFT JOIN grades g ON s.student_code = g.student_code 
    WHERE s.student_code = '$student_code'
    ";

        $result = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_assoc($result);

        // Giải mã JSON từ cột 'grades'
        $grades = $row['grades'] ? json_decode($row['grades'], true) : [];

        // Lọc danh sách các mã học phần đã có điểm
        $valid_course_codes = [];
        foreach ($grades as $course_code => $grade) {
            if (!is_null($grade) && $grade !== '') { // Chỉ lấy các môn có điểm
                $valid_course_codes[] = $course_code;
            }
        }

        // Nếu không có môn nào có điểm, tổng tín chỉ là 0
        $total_credits = 0;
        if (!empty($valid_course_codes)) {
            // Tạo danh sách mã học phần hợp lệ để dùng trong truy vấn
            $course_codes_list = "'" . implode("','", $valid_course_codes) . "'";

            // Query tính tổng tín chỉ của các môn có điểm
            $total_credits_query = "
            SELECT SUM(credits) as total_credits 
            FROM courses 
            WHERE course_code IN ($course_codes_list)
        ";
            $credits_result = mysqli_query($this->conn, $total_credits_query);
            $credits_row = mysqli_fetch_assoc($credits_result);
            $total_credits = $credits_row['total_credits'] ?? 0;
        }

        // Lấy số học phần trong trường grade của bảng grades
        $grade_courses_count = count($valid_course_codes);

        // Lấy tổng số học phần của bảng courses
        $courses_query = "SELECT COUNT(*) as total_courses FROM courses";
        $courses_result = mysqli_query($this->conn, $courses_query);
        $courses_row = mysqli_fetch_assoc($courses_result);
        $total_courses_count = $courses_row['total_courses'];

        // Thêm số học phần và tổng tín chỉ vào biến $row
        $row['grade_courses_count'] = $grade_courses_count; // Số học phần đã có điểm
        $row['total_courses_count'] = $total_courses_count; // Tổng số học phần trong hệ thống
        $row['grade_course_credits'] = $total_credits; // Tổng tín chỉ các môn có điểm

        // Chuyển chuỗi JSON thành mảng
        $course_grade = [];
        foreach ($grades as $course_code => $grade) {
            $course_query = "SELECT course_name, credits, optional, accumulation FROM courses WHERE course_code = '$course_code'";
            $course_result = mysqli_query($this->conn, $course_query);
            $course_row = mysqli_fetch_assoc($course_result);

            if ($course_row) {
                $course_grade[] = [
                    'course_code' => $course_code,
                    'course_name' => $course_row['course_name'],
                    'credits' => !empty($course_row['credits']) ? $course_row['credits'] : 0,
                    'grade' => !empty($grade) ? $grade : 'Chưa có điểm',
                    'optional' => isset($course_row['optional']) ? $course_row['optional'] : 0,
                    'accumulation' => isset($course_row['accumulation']) ? $course_row['accumulation'] : 0,
                ];
            }
        }

        // Thêm mảng course_grade vào biến $row
        $row['course_grades'] = $course_grade;

        return $row;
    }



    // function getCoursesTree($student_code)
    // {
    //     $student_code = mysqli_real_escape_string($this->conn, $student_code);
    //     $queryGetAllCourses = "SELECT * FROM courses";
    //     $resultGetAllCourses = mysqli_query($this->conn, $queryGetAllCourses);
    //     $courses = [];
    //     while ($row = mysqli_fetch_assoc($resultGetAllCourses)) {
    //         $courses[] = $row;
    //     }
    //     $queryGetGrades = "SELECT grade FROM grades WHERE student_code = '$student_code'";
    //     $resultGetGrades = mysqli_query($this->conn, $queryGetGrades);
    //     $gradeCourses = "";
    //     while ($row = mysqli_fetch_assoc($resultGetGrades)) {
    //         $gradeCourses = $row['grade'];
    //     }

    //     $gradeCoursesArray = [];
    //     if ($gradeCourses !== "") {
    //         $gradeCoursesArray = json_decode($gradeCourses, true);
    //     }


    //     // Tạo một mảng tạm thời để lưu trữ các khóa học theo cấu trúc cây
    //     $tempCourses = [];
    //     foreach ($courses as $course) {
    //         if ( !empty($gradeCoursesArray) && array_key_exists($course['course_code'], $gradeCoursesArray)) {
    //             if (intval($gradeCoursesArray[$course['course_code']]) >= 5) {
    //                 $tempCourses[$course['id']] = [
    //                     'course_name' => $course['course_name'],
    //                     'pre_course' => $course['pre_course'],
    //                     'color' => 'green',
    //                     'children' => []
    //                 ];
    //             } else {
    //                 $tempCourses[$course['id']] = [
    //                     'course_name' => $course['course_name'],
    //                     'pre_course' => $course['pre_course'],
    //                     'color' => 'yellow',
    //                     'children' => []
    //                 ];
    //             }
    //         } else {
    //             $tempCourses[$course['id']] = [
    //                 'course_name' => $course['course_name'],
    //                 'pre_course' => $course['pre_course'],
    //                 'color' => 'red',
    //                 'children' => []
    //             ];
    //         }
    //     }

    //     // Tạo mảng để lưu trữ các đối tượng học phần của cây hoàn chỉnh
    //     $coursesTree = [];

    //     // Xây dựng cấu trúc cây
    //     foreach ($tempCourses as $id => &$course) {
    //         if ($course['pre_course'] === null) {
    //             $coursesTree[] = &$course;
    //         } else {
    //             $tempCourses[$course['pre_course']]['children'][] = &$course;
    //         }
    //     }

    //     return $coursesTree;
    // }
}
