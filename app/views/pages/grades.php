<?php
require_once "app/controller/CourseController.php";
require_once "app/controller/GradeController.php";
$courseController = new CourseController($conn);
$gradeController = new GradeController($conn);

// Lấy tham số trang hiện tại từ URL, mặc định là trang 1
$page = isset($_GET['num']) ? (int)$_GET['num'] : 1;
$page = max($page, 1);
$limit = 10; // Số lượng sinh viên mỗi trang
$offset = ($page - 1) * $limit;

// Lấy danh sách học phần
$courses = $courseController->index(null, null);
$course = isset($_GET['course']) ? $_GET['course'] : '';
$search = isset($_POST['search']) ? $_POST['search'] : '';

if ($search) {
    $grades = $gradeController->search($search, $course);
    $total_courses = count($grades);
    $total_pages = 1;
} else {
    $grades = $gradeController->index($limit, $offset, $course);
    $total_courses = $courseController->count();
    $total_pages = ceil($total_courses / $limit);
}
?>

<nav aria-label="Page navigation example">
    <?php if (isset($_GET['message'])): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?php echo $_GET['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <input class="form-control form-control-sm mb-2" style="width: 385px;" name="course" id="coursePageSelect" list="coursePageList" placeholder="<?php echo $course?htmlspecialchars($course):'Chọn học phần'; ?>">
    <datalist id="coursePageList">
        <option value=''>Chọn học phần</option>
        <?php foreach ($courses as $c): ?>
            <option value="<?php echo $c['course_code']; ?>">
                <?php echo htmlspecialchars($c['course_name']); ?>
            </option>
        <?php endforeach; ?>
    </datalist>
    <form class="d-flex float-start" method="post" style="height: 35px;">
        <input class="form-control-sm me-2" name="search" type="search" placeholder="Nhập mã sinh viên" aria-label="Search" required>
        <button class="btn btn-outline-success" type="submit" style="width:200px;">Tìm kiếm</button>
    </form>
    <button type="button" class="btn btn-primary float-end d-flex align-items-center ms-2" data-bs-toggle="modal" data-bs-target="#addGradeModal"><i class="material-icons">add</i> Thêm</button>
    <button type="button" class="btn btn-warning float-end d-flex align-items-center text-white" data-bs-toggle="modal" data-bs-target="#importFileModal"><i class="material-icons">cloud_download</i> Nhập file</button>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Mã sinh viên</th>
                <th scope="col">Họ tên sinh viên</th>
                <th scope="col">Điểm số</th>
                <th scope="col">Điểm chữ</th>
                <th scope="col">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($grades as $index => $grade): ?>
                <tr>
                    <th scope="row"><?php echo $index + 1; ?></th>
                    <td><?php echo htmlspecialchars($grade['student_code']); ?></td>
                    <td><?php echo htmlspecialchars($grade['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($grade['course_grade']); ?></td>
                    <td>
                        <?php
                        if ($grade['course_grade'] >= 9) {
                            echo 'A';
                        } elseif ($grade['course_grade'] >= 8) {
                            echo 'B';
                        } elseif ($grade['course_grade'] >= 6.5) {
                            echo 'C';
                        } elseif ($grade['course_grade'] >= 5) {
                            echo 'D';
                        } else {
                            echo 'F';
                        }
                        ?>
                    </td>
                    <td>
                        <form action="app/controller/GradeController.php" method="POST" style="display:inline;">
                            <input type="hidden" name="action" value="destroy">
                            <input type="hidden" name="id" value="<?php echo $grade['id']; ?>">
                            <input type="hidden" name="course" value="<?php echo $course; ?>">
                            <button type="submit" class="btn btn-danger btn-sm"><i class="material-icons">delete</i></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <ul class="pagination">
        <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
            <a class="page-link" href="?page=grades&num=<?php echo $page - 1; ?>&course=<?php echo $course ?>">Trước</a>
        </li>
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?php if ($page == $i) echo 'active'; ?>">
                <a class="page-link" href="?page=grades&num=<?php echo $i; ?>&course=<?php echo $course ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>
        <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
            <a class="page-link" href="?page=grades&num=<?php echo $page + 1; ?>&course=<?php echo $course ?>">Sau</a>
        </li>
    </ul>
    <!-- Modal thêm điểm học phần -->
    <?php
    $modalId = "addGradeModal";
    $modalLabelId = "addGradeModalLabel";
    $modalTitle = "Thêm điểm";
    $formAction = "/app/controller/GradeController.php";
    $formId = "addGradeForm";
    $formContent = '
    <input type="hidden" name="action" value="store">
    <div class="mb-3 container">
        <label for="student_code" class="form-label">Mã sinh viên</label>
        <input type="text" class="form-control" id="student_id" placeholder="Nhập mã sinh viên" name="student_code" required>
        <div id="gradeFieldsContainer" class="mt-2"></div>
        <input class="btn btn-primary mt-2" type="button" value="+ Thêm học phần" id="addGradeButton"/>
    </div>
    ';
    include 'app/views/components/modal.php';
    ?>

    <?php
    $modalId = "importFileModal";
    $modalLabelId = "importFileModalLabel";
    $modalTitle = "Nhập thông tin từ file";
    $formAction = "/app/controller/GradeController.php";
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Đặt lại form khi modal bị đóng
        $('#<?php echo $modalId; ?>').on('hidden.bs.modal', function() {
            $('#<?php echo $formId; ?>')[0].reset();
            $('#gradeFieldsContainer').empty(); // Xóa các trường điểm đã thêm
        });
    });
</script>