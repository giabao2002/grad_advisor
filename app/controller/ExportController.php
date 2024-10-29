<?php
// Nạp thư viện SimpleXLSXGen
require_once '/xampp/htdocs/core/SimpleXLSXGen.php';
require_once '/xampp/htdocs/app/controller/GraduateController.php';

use Shuchkin\SimpleXLSXGen;

$status = $_GET['status'];

$graduate = new GraduateController($conn);
$students = $graduate->index( PHP_INT_MAX, 0,$status);

// Chuyển đổi dữ liệu trong biến $students cho phù hợp với định dạng của biến $data
$data = [
    ['Mã sinh viên', 'Họ tên', 'Giới tính', 'Ngày Sinh', 'Email','Địa chỉ', 'Ngành học', 'CCCD/CMND', 'Tình trạng','Điều kiện tốt nghiệp' ]
];

foreach ($students as $student) {
    $data[] = [
        $student['student_code'],
        $student['full_name'],
        $student['gender'],
        DateTime::createFromFormat('Y-m-d', $student['dob'])->format('d/m/Y'), // Định dạng lại ngày sinh
        $student['email'],
        $student['address'],
        $student['major'],
        $student['identity'],
        $student['status'],
    ];
    if($status == "1"){
        $data[count($data) - 1][] = "Đủ điều kiện";
    }else{
        $data[count($data) - 1][] = "Chưa đủ điều kiện";
    }
}

// Tạo file Excel từ dữ liệu
$xlsx = SimpleXLSXGen::fromArray($data);
$filename = "";
if($status == "1"){
    $filename = "dssv_du_dk_tot_nghiep.xlsx";
}else{
    $filename = "dssv_chua_du_dk_tot_nghiep.xlsx";
}
$xlsx->downloadAs($filename);

