<?php
require_once("/xampp/htdocs/core/db_connect.php");

class GraduateController
{
    private $conn;


    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function index($limit = PHP_INT_MAX, $offset = 0, $status)
    {

        $query = "";
        if ($status == "1") {
            $query = "
                SELECT s.*
                FROM students s
                JOIN grades g ON s.student_code = g.student_code
                WHERE 
                    -- Kiểm tra có ít nhất một môn tự chọn đạt >= 5
                    (SELECT COUNT(*)
                    FROM courses c
                    WHERE c.optional = 'Tự chọn' 
                    AND JSON_UNQUOTE(JSON_EXTRACT(g.grade, CONCAT('$.\"', c.course_code, '\"'))) >= 5) >= 1
                    
                    -- Kiểm tra tất cả các môn bắt buộc đều đạt > 5
                    AND (SELECT COUNT(*)
                    FROM courses c
                    WHERE c.optional = 'Bắt buộc' 
                    AND JSON_UNQUOTE(JSON_EXTRACT(g.grade, CONCAT('$.\"', c.course_code, '\"'))) >= 5) >= 1

                    -- Đảm bảo tổng tín chỉ các môn đạt >= 5 là >= 130
                    AND (SELECT SUM(c.credits)
                        FROM courses c
                        WHERE JSON_UNQUOTE(JSON_EXTRACT(g.grade, CONCAT('$.\"', c.course_code, '\"'))) >= 5) >= 130
                    
                    -- Đảm bảo các điều kiện khác
                    AND g.language = 'Đạt'
                    AND g.military = 'Đạt'
                    AND g.infomatic = 'Đạt'
                LIMIT $offset, $limit
            ";
        } else {
            $query = "
                SELECT s.*
                FROM students s
                LEFT JOIN grades g ON s.student_code = g.student_code
                WHERE (
                    g.student_code IS NULL
                    OR (
                        SELECT COUNT(*)
                        FROM courses c
                        WHERE JSON_CONTAINS_PATH(g.grade, 'one', CONCAT('$.\"', c.course_code, '\"'))
                    ) < (SELECT COUNT(*) FROM courses)
                    OR (
                        SELECT COUNT(*)
                        FROM courses c
                        WHERE JSON_UNQUOTE(JSON_EXTRACT(g.grade, CONCAT('$.\"', c.course_code, '\"'))) < 5
                    ) > 0
                    OR g.language != 'Đạt'
                    OR g.military != 'Đạt'
                    OR g.infomatic != 'Đạt'
                    OR g.grade IS NULL
                    OR g.grade = ''
                )
                LIMIT $offset, $limit
            ";
        }

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


    public function show($student_code, $status)
    {
        $query = "";
        if ($status == "1") {
            $query = "
                SELECT s.*
                FROM students s
                JOIN grades g ON s.student_code = g.student_code
                WHERE (
                    SELECT COUNT(*)
                    FROM courses c
                    WHERE JSON_CONTAINS_PATH(g.grade, 'one', CONCAT('$.\"', c.course_code, '\"'))
                ) = (SELECT COUNT(*) FROM courses)
                AND (
                    SELECT COUNT(*)
                    FROM courses c
                    WHERE JSON_UNQUOTE(JSON_EXTRACT(g.grade, CONCAT('$.\"', c.course_code, '\"'))) >= 5
                ) = (SELECT COUNT(*) FROM courses)
                AND g.language = 'Đạt'
                AND g.military = 'Đạt'
                AND g.infomatic = 'Đạt'
                AND s.student_code = '$student_code'
            ";
        } else {
            $query = "
                SELECT s.*
                FROM students s
                LEFT JOIN grades g ON s.student_code = g.student_code
                WHERE (
                    g.student_code IS NULL
                    OR (
                        SELECT COUNT(*)
                        FROM courses c
                        WHERE JSON_CONTAINS_PATH(g.grade, 'one', CONCAT('$.\"', c.course_code, '\"'))
                    ) < (SELECT COUNT(*) FROM courses)
                    OR (
                        SELECT COUNT(*)
                        FROM courses c
                        WHERE JSON_UNQUOTE(JSON_EXTRACT(g.grade, CONCAT('$.\"', c.course_code, '\"'))) < 5
                    ) > 0
                    OR g.language != 'Đạt'
                    OR g.military != 'Đạt'
                    OR g.infomatic != 'Đạt'
                    OR g.grade IS NULL
                    OR g.grade = ''
                    AND s.student_code = '$student_code'
                )
            ";
        }
        $result = mysqli_query($this->conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $students = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $students;
        } else {
            return [];
        }
    }

    public function update($student_code, $cert, $status)
    {
        var_dump($student_code, $cert, $status);
        $newStatus = "";
        if ($status == "Đạt") {
            $newStatus = "Chưa đạt";
        } else {
            $newStatus = "Đạt";
        }
        $query = "UPDATE grades SET $cert='$newStatus' WHERE student_code='$student_code'";
        if (mysqli_query($this->conn, $query)) {
            return true;
        } else {
            return false;
        }
    }
}


$graduateController = new GraduateController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['cert'])) {
        $cert = $_GET['cert'];
        $status = $_GET['status'];
        $student_code = $_GET['student_code'];
        $graduateController->update($student_code, $cert, $status);
        header("Location: /?page=detail&student_code=$student_code");
    }
}
