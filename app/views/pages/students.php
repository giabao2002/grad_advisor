<?php
require_once "app/controller/StudentController.php";
$studentController = new StudentController($conn);

// Lấy tham số trang hiện tại từ URL, mặc định là trang 1
$page = isset($_GET['num']) ? (int)$_GET['num'] : 1;
$page = max($page, 1);
$limit = 10; // Số lượng sinh viên mỗi trang
$offset = ($page - 1) * $limit;

$search = isset($_POST['search']) ? $_POST['search'] : '';
if ($search) {
    $students = $studentController->show($search);
    $total_students = count($students);
    $total_pages = 1;
} else {
    //Lấy danh sách sinh viên và tổng số sinh viên
    $students = $studentController->index($limit, $offset);
    $total_students = $studentController->count();
    $total_pages = ceil($total_students / $limit);
}
?>

<nav aria-label="Page navigation example">
    <?php if (isset($_GET['message'])): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?php echo $_GET['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <form class="d-flex float-start" method="post">
        <input class="form-control-sm me-2" name="search" type="search" placeholder="Nhập mã sinh viên" aria-label="Search" required>
        <button class="btn btn-outline-success mr-2" type="submit">Tìm kiếm</button>
    </form>
    <?php if ($_SESSION['auth_user']['role'] == 'GV'): ?>
        <button type="button" class="btn btn-primary float-end d-flex align-items-center ms-2" data-bs-toggle="modal" data-bs-target="#addStudentModal"><i class="material-icons">add</i> Thêm sinh viên</button>
        <button type="button" class="btn btn-warning float-end d-flex align-items-center text-white" data-bs-toggle="modal" data-bs-target="#importFileModal"><i class="material-icons">cloud_download</i> Nhập file</button>
    <?php endif; ?>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Mã SV</th>
                <th scope="col">Họ tên</th>
                <th scope="col">Phái</th>
                <th scope="col">Ngày sinh</th>
                <th scope="col">CCCD</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Email</th>
                <th scope="col">Chuyên ngành</th>
                <th scope="col">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $index => $student): ?>
                <tr>
                    <th scope="row"><?php echo $index + 1; ?></th>
                    <td><?php echo htmlspecialchars($student['student_code']); ?></td>
                    <td><?php echo htmlspecialchars($student['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($student['gender']); ?></td>
                    <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($student['dob']))); ?></td>
                    <td><?php echo htmlspecialchars($student['identity']); ?></td>
                    <td><?php echo htmlspecialchars($student['status']); ?></td>
                    <td><?php echo htmlspecialchars($student['email']); ?></td>
                    <td>
                        <?php
                        $major_code = $student['major'];
                        $query = "Select major_name from majors where major_code = '$major_code'";
                        $result = mysqli_query($conn, $query);

                        if ($result && mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            echo $row['major_name'];
                        } else {
                            echo "";
                        }
                        ?>
                    </td>
                    <td>
                        <?php if ($_SESSION['auth_user']['role'] == 'GV'): ?>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editStudentModal"
                                data-id="<?php echo $student['id']; ?>"
                                data-student_code="<?php echo htmlspecialchars($student['student_code']); ?>"
                                data-full_name="<?php echo htmlspecialchars($student['full_name']); ?>"
                                data-dob="<?php echo htmlspecialchars($student['dob']); ?>"
                                data-identity="<?php echo htmlspecialchars($student['identity']); ?>"
                                data-address="<?php echo htmlspecialchars($student['address']); ?>"
                                data-gender="<?php echo htmlspecialchars($student['gender']); ?>"
                                data-email="<?php echo htmlspecialchars($student['email']); ?>">
                                <i class="material-icons">edit</i>
                            </button>
                            <form action="app/controller/StudentController.php" method="POST" style="display:inline;">
                                <input type="hidden" name="action" value="destroy">
                                <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm"><i class="material-icons">delete</i></button>
                            </form>
                        <?php endif; ?>
                        <a type="button" class="btn btn-sm" href="?page=detail&student_code=<?php echo $student['student_code'] ?>"><i class="material-icons">visibility</i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <ul class="pagination">
        <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
            <a class="page-link" href="?page=students&num=<?php echo $page - 1; ?>">Trước</a>
        </li>
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?php if ($page == $i) echo 'active'; ?>">
                <a class="page-link" href="?page=students&num=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>
        <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
            <a class="page-link" href="?page=students&num=<?php echo $page + 1; ?>">Sau</a>
        </li>
    </ul>
    <!-- Modal thêm sinh viên -->
    <?php
    $modalId = "addStudentModal";
    $modalLabelId = "addStudentModalLabel";
    $modalTitle = "Thêm sinh viên";
    $formAction = "/app/controller/StudentController.php";
    $formId = "addStudentForm";
    $formContent = '
        <input type="hidden" name="action" value="store">
        <div class="mb-3">
            <label for="student_code" class="form-label">Mã sinh viên</label>
            <input type="text" class="form-control" id="student_code" placeholder="Nhập mà sinh viên" name="student_code" required>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Tên sinh viên</label>
            <input type="text" class="form-control" id="name" placeholder="Nhập tên đầy đủ" name="full_name" required>
        </div>
        <div class="mb-3">
            <label for="dob" class="form-label">Ngày sinh</label>
            <input type="date" class="form-control" id="dob" name="dob" required>
        </div>
        <div class="mb-3">
            <label for="identity" class="form-label">CCCD/CMND</label>
            <input type="text" class="form-control" id="identity" name="identity" placeholder="Nhập số CCCD/CMND" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Địa chỉ</label>
            <input type="text" class="form-control" id="address" name="address" placeholder="Nhập địa chỉ" required>  
        </div>
        <div class="mb-3">
            <label for="gender" class="form-label">Giới tính</label>
            <select name="gender" id="gender" class="form-select" required>
                <option value="Nam" selected>Nam</option>
                <option value="Nữ">Nữ</option>
                <option value="khác">Khác</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" placeholder="name@example.com" name="email" required>
        </div>';
    include 'app/views/components/modal.php';
    ?>

    <!-- Modal chỉnh sửa thông tin sinh viên -->
    <?php
    $modalId = "editStudentModal";
    $modalLabelId = "editStudentModalLabel";
    $modalTitle = "Sửa thông tin sinh viên";
    $formAction = "/app/controller/StudentController.php";
    $formId = "editStudentForm";
    $formContent = '
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="id" id="id">
        <div class="mb-3">
            <label for="student_code" class="form-label">Mã sinh viên</label>
            <input type="text" class="form-control" id="student_code" name="student_code" required>
        </div>
        <div class="mb-3">
            <label for="full_name" class="form-label">Tên sinh viên</label>
            <input type="text" class="form-control" id="full_name" name="full_name" required>
        </div>
        <div class="mb-3">
            <label for="dob" class="form-label">Ngày sinh</label>
            <input type="date" class="form-control" id="dob" name="dob" required>
        </div>
        <div class="mb-3">
            <label for="identity" class="form-label">CCCD/CMND</label>
            <input type="text" class="form-control" id="identity" name="identity" placeholder="Nhập số CCCD/CMND" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Địa chỉ</label>
            <input type="text" class="form-control" id="address" name="address" placeholder="Nhập địa chỉ" required>  
        </div>
        <div class="mb-3">
            <label for="gender" class="form-label">Giới tính</label>
            <select name="gender" id="gender" class="form-select" required>
                <option value="Nam" selected>Nam</option>
                <option value="Nữ">Nữ</option>
                <option value="khác">Khác</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>';
    include 'app/views/components/modal.php';
    ?>

    <?php
    $modalId = "importFileModal";
    $modalLabelId = "importFileModalLabel";
    $modalTitle = "Nhập thông tin từ file";
    $formAction = "/app/controller/StudentController.php";
    $formId = "importFileForm";
    $formContent = '
    <input type="hidden" name="action" value="import">
    <div class="mb-3 container">
        <label for="file" class="form-label">Chọn file</label>
        <input type="file" class="form-control" id="file" name="data" required>
    </div>
    ';
    include 'app/views/components/modal.php';
    ?>
</nav>