<?php
require_once("/xampp/htdocs/core/db_connect.php");

class MajorsController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function index($limit, $offset)
    {
        $query = "SELECT * FROM majors" . (($limit !== null && $offset !== null) ? " LIMIT $limit OFFSET $offset" : "");
        $result = mysqli_query($this->conn, $query);
        $majors = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $majors;
    }

    public function count()
    {
        $query = "SELECT COUNT(*) as total FROM majors";
        $result = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    }

    public function store($data)
    {
        $major_name = $data['major_name'];
        $major_code = $data['major_code'];

        // Kiểm tra xem ngành đã tồn tại hay chưa
        $check_query = "SELECT * FROM majors WHERE major_code = '$major_code' OR major_name = '$major_name'";
        $result = mysqli_query($this->conn, $check_query);

        if (mysqli_num_rows($result) > 0) {
            // ngành đã tồn tại
            return "Ngành đã tồn tại";
        } else {
            // Thêm mới ngành
            $insert_query = "INSERT INTO majors (major_name, major_code) VALUES ('$major_name', '$major_code')";
            $result = mysqli_query($this->conn, $insert_query);

            if ($result) {
                return "Thêm mới ngành thành công";
            } else {
                return "Thêm mới ngành thất bại";
            }
        }
    }

    public function destroy($id)
    {
        $query = "DELETE FROM majors WHERE id = $id";
        $result = mysqli_query($this->conn, $query);

        if ($result) {
            return "Xóa ngành thành công";
        } else {
            return "Xóa ngành thất bại";
        }
    }
}

$majorsController = new MajorsController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'store':
                $data = [
                    'major_name' => $_POST['major_name'],
                    'major_code' => $_POST['major_code']
                ];
                $response = $majorsController->store($_POST);
                if (gettype($response) == "string") {
                    header("Location: /?page=majors&message=$response");
                } else {
                    header("Location: /?page=majors");
                }
                break;
            case 'destroy':
                $id = $_POST['id'];
                $response = $majorsController->destroy($id);
                header("Location: /?page=majors");
                break;
        }
    }
}
