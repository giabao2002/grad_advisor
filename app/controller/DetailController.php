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
        // ngăn chặn SQL Injection
        $student_code = mysqli_real_escape_string($this->conn, $student_code);

        $query = "
        SELECT 
        s.*, 
        g.grade AS grades, 
        g.language as language,
        g.infomatic as infomatic,
        g.military as military
        FROM students s 
        LEFT JOIN grades g ON s.student_code = g.student_code 
        WHERE s.student_code = '$student_code'
        ";

        $result = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_assoc($result);
        // Lấy số học phần trong trường grade của bảng grades
        $grade_courses_count = $row['grades'] ? count(json_decode($row['grades'], true)) : 0;

        // Lấy tổng số học phần của bảng courses
        $courses_query = "SELECT COUNT(*) as total_courses FROM courses";
        $courses_result = mysqli_query($this->conn, $courses_query);
        $courses_row = mysqli_fetch_assoc($courses_result);
        $total_courses_count = $courses_row['total_courses'];

        // Thêm số học phần vào biến $row
        $row['grade_courses_count'] = $grade_courses_count;
        $row['total_courses_count'] = $total_courses_count;

        // Chuyển chuỗi JSON thành mảng
        $course_grade = [];
        if ($row['grades']) {
            $grades = json_decode($row['grades'], true);
            // Lặp qua mảng grades để lấy thông tin học phần
            foreach ($grades as $course_code => $grade) {
                $course_query = "SELECT course_name, credits FROM courses WHERE course_code = '$course_code'";
                $course_result = mysqli_query($this->conn, $course_query);
                $course_row = mysqli_fetch_assoc($course_result);

                $course_grade[] = [
                    'course_name' => $course_row['course_name'],
                    'grade' => $grade,
                    'credits' => $course_row['credits']
                ];
            }
        }

        // Thêm mảng course_grade vào biến $row
        $row['course_grades'] = $course_grade;

        return $row;
    }

    function getCoursesTree($student_code)
    {
        $student_code = mysqli_real_escape_string($this->conn, $student_code);
        $queryGetAllCourses = "SELECT * FROM courses";
        $resultGetAllCourses = mysqli_query($this->conn, $queryGetAllCourses);
        $courses = [];
        while ($row = mysqli_fetch_assoc($resultGetAllCourses)) {
            $courses[] = $row;
        }
        $queryGetGrades = "SELECT grade FROM grades WHERE student_code = '$student_code'";
        $resultGetGrades = mysqli_query($this->conn, $queryGetGrades);
        $gradeCourses = "";
        while ($row = mysqli_fetch_assoc($resultGetGrades)) {
            $gradeCourses = $row['grade'];
        }

        $gradeCoursesArray = [];
        if ($gradeCourses !== "") {
            $gradeCoursesArray = json_decode($gradeCourses, true);
        }


        // Tạo một mảng tạm thời để lưu trữ các khóa học theo cấu trúc cây
        $tempCourses = [];
        foreach ($courses as $course) {
            if ( !empty($gradeCoursesArray) && array_key_exists($course['course_code'], $gradeCoursesArray)) {
                if (intval($gradeCoursesArray[$course['course_code']]) >= 5) {
                    $tempCourses[$course['id']] = [
                        'course_name' => $course['course_name'],
                        'pre_course' => $course['pre_course'],
                        'color' => 'green',
                        'children' => []
                    ];
                } else {
                    $tempCourses[$course['id']] = [
                        'course_name' => $course['course_name'],
                        'pre_course' => $course['pre_course'],
                        'color' => 'yellow',
                        'children' => []
                    ];
                }
            } else {
                $tempCourses[$course['id']] = [
                    'course_name' => $course['course_name'],
                    'pre_course' => $course['pre_course'],
                    'color' => 'red',
                    'children' => []
                ];
            }
        }

        // Tạo mảng để lưu trữ các đối tượng học phần của cây hoàn chỉnh
        $coursesTree = [];

        // Xây dựng cấu trúc cây
        foreach ($tempCourses as $id => &$course) {
            if ($course['pre_course'] === null) {
                $coursesTree[] = &$course;
            } else {
                $tempCourses[$course['pre_course']]['children'][] = &$course;
            }
        }

        return $coursesTree;
    }
}
