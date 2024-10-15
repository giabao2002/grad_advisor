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

// Lấy danh sách môn học
$courses = $courseController->index($limit, $offset);
$course = isset($_GET['course']) ? $_GET['course'] : '';
$search = isset($_POST['search']) ? $_POST['search'] : '';

if ($search) {
    $grades = $gradeController->search($search,$course);
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
    <select class="form-select form-select-sm mb-2" style="width: 385px;" name="course" id="courseSelect">
        <option value=''>Chọn môn học</option>
        <?php foreach ($courses as $c): ?>
            <option value="<?php echo $c['course_code']; ?>" <?php echo $course == $c['course_code'] ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($c['course_name']); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <form class="d-flex float-start" method="post" style="height: 35px;">
        <input class="form-control-sm me-2" name="search" type="search" placeholder="Nhập mã sinh viên" aria-label="Search" required>
        <button class="btn btn-outline-success" type="submit" style="width:200px;">Tìm kiếm</button>
    </form>
    <button type="button" class="btn btn-primary float-end d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addGradeModal"><i class="material-icons">add</i> Thêm</button>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Mã sinh viên</th>
                <th scope="col">Họ tên sinh viên</th>
                <th scope="col">Điểm số</th>
                <th scope="col"></th>
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
            <a class="page-link" href="?page=courses&num=<?php echo $page - 1; ?>">Trước</a>
        </li>
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?php if ($page == $i) echo 'active'; ?>">
                <a class="page-link" href="?page=courses&num=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>
        <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
            <a class="page-link" href="?page=courses&num=<?php echo $page + 1; ?>">Sau</a>
        </li>
    </ul>
    <!-- Modal thêm môn học -->
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
            <input class="btn btn-primary mt-2" type="button" value="+ Thêm môn học" id="addGradeButton"/>
        </div>
        ';
    include 'app/views/components/modal.php';
    ?>
</nav>