<?php
require_once "app/controller/CourseController.php";
$courseController = new CourseController($conn);

// Lấy tham số trang hiện tại từ URL, mặc định là trang 1
$page = isset($_GET['num']) ? (int)$_GET['num'] : 1;
$page = max($page, 1);
$limit = 10; // Số lượng sinh viên mỗi trang
$offset = ($page - 1) * $limit;

$search = isset($_POST['search']) ? $_POST['search'] : '';
$search_by = isset($_POST['search_by']) ? $_POST['search_by'] : '';
if ($search && $search_by) {
    $courses = $courseController->search($search, $search_by);
    $total_courses = count($courses);
    $total_pages = 1;
} else {
    $courses = $courseController->index($limit, $offset);
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
    <form class="d-flex float-start" method="post" style="height: 35px;">
        <input class="form-control-sm me-2" name="search" type="search" placeholder="Nhập thông tin" aria-label="Search" required>
        <select class="form-select form-select-sm me-2" name="search_by">
            <option value="course_code" selected>Mã môn học</option>
            <option value="year">Năm học</option>
            <option value="credits">Số tín chỉ</option>
        </select>
        <button class="btn btn-outline-success" type="submit" style="width:200px;">Tìm kiếm</button>
    </form>
    <button type="button" class="btn btn-primary float-end d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addCourseModal"><i class="material-icons">add</i> Thêm môn học</button>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Mã môn học</th>
                <th scope="col">Tên môn học</th>
                <th scope="col">Số tín chỉ</th>
                <th scope="col">Học kỳ</th>
                <th scope="col">Năm học</th>
                <th scope="col">Môn học tiên quyết</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($courses as $index => $course): ?>
                <tr>
                    <th scope="row"><?php echo $index + 1; ?></th>
                    <td><?php echo htmlspecialchars($course['course_code']); ?></td>
                    <td><?php echo htmlspecialchars($course['course_name']); ?></td>
                    <td><?php echo htmlspecialchars($course['credits']); ?></td>
                    <td><?php echo htmlspecialchars($course['semester']); ?></td>
                    <td><?php echo htmlspecialchars($course['year']); ?></td>
                    <td><?php echo htmlspecialchars($course['pre_course_name']); ?></td>
                    <td>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editCourseModal"
                            data-id="<?php echo $course['id']; ?>"
                            data-course_code="<?php echo htmlspecialchars($course['course_code']); ?>"
                            data-course_name="<?php echo htmlspecialchars($course['course_name']); ?>"
                            data-credits="<?php echo htmlspecialchars($course['credits']); ?>"
                            data-semester="<?php echo htmlspecialchars($course['semester']); ?>"
                            data-year="<?php echo htmlspecialchars($course['year']); ?>"
                            data-pre_course="<?php echo htmlspecialchars($course['pre_course']); ?>">
                            <i class="material-icons">edit</i>
                        </button>
                        <form action="app/controller/CourseController.php" method="POST" style="display:inline;">
                            <input type="hidden" name="action" value="destroy">
                            <input type="hidden" name="id" value="<?php echo $course['id']; ?>">
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
    $modalId = "addCourseModal";
    $modalLabelId = "addCourseModalLabel";
    $modalTitle = "Thêm môn học";
    $formAction = "/app/controller/CourseController.php";
    $formId = "addCourseForm";
    $options = '<option value="">Chọn môn học tiên quyết</option>';
    foreach ($courses as $course) {
        $options .= '<option value="' . $course['id'] . '">' . htmlspecialchars($course['course_name']) . '</option>';
    }
    $formContent = '
        <input type="hidden" name="action" value="store">
        <div class="mb-3">
            <label for="student_code" class="form-label">Mã môn học</label>
            <input type="text" class="form-control" id="course_code" placeholder="Nhập mã môn học" name="course_code" required>
        </div>
        <div class="mb-3">
            <label for="course_name" class="form-label">Tên môn học</label>
            <input type="text" class="form-control" id="course_name" placeholder="Nhập tên môn học" name="course_name" required>
        </div>
        <div class="mb-3">
            <label for="credits" class="form-label">Số tín chỉ</label>
            <input type="number" class="form-control" id="credits" name="credits" required>
        </div>
        <div class="mb-3">
            <label for="semester" class="form-label">Kỳ học</label>
            <input type="number" class="form-control" id="semester" placeholder="Nhập kỳ học" name="semester">
        </div>
        <div class="mb-3">
            <label for="year" class="form-label">Năm học</label>
            <input type="number" class="form-control" id="year" placeholder="Nhập năm học" name="year">
        </div>
        <div class="mb-3">
        <label for="pre_course" class="form-label">Môn học tiên quyết</label>
            <select class="form-control" id="pre_course" name="pre_course">
                ' . $options . '
            </select>
        </div>';
    include 'app/views/components/modal.php';
    ?>

    <!-- Modal chỉnh sửa thông tin môn học -->
    <?php
    $modalId = "editCourseModal";
    $modalLabelId = "editCourseModalLabel";
    $modalTitle = "Sửa thông tin môn học";
    $formAction = "/app/controller/CourseController.php";
    $formId = "editCourseForm";
    $options = '<option value="">Chọn môn học tiên quyết</option>';
    foreach ($courses as $course) {
        $options .= '<option value="' . $course['id'] . '">' . htmlspecialchars($course['course_name']) . '</option>';
    }
    $formContent = '
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="id" id="id">
        <div class="mb-3">
            <label for="course_code" class="form-label">Mã môn học</label>
            <input type="text" class="form-control" id="course_code" placeholder="Nhập mã môn học" name="course_code" required>
        </div>
        <div class="mb-3">
            <label for="course_name" class="form-label">Tên môn học</label>
            <input type="text" class="form-control" id="course_name" placeholder="Nhập tên môn học" name="course_name" required>
        </div>
        <div class="mb-3">
            <label for="credits" class="form-label">Số tín chỉ</label>
            <input type="number" class="form-control" id="credits" name="credits" required>
        </div>
        <div class="mb-3">
            <label for="semester" class="form-label">Kỳ học</label>
            <input type="number" class="form-control" id="semester" placeholder="Nhập kỳ học" name="semester">
        </div>
        <div class="mb-3">
            <label for="year" class="form-label">Năm học</label>
            <input type="number" class="form-control" id="year" placeholder="Nhập năm học" name="year">
        </div>
        <div class="mb-3">
        <label for="pre_course" class="form-label">Môn học tiên quyết</label>
            <select class="form-control" id="pre_course" name="pre_course">
                ' . $options . '
            </select>
        </div>';
    include 'app/views/components/modal.php';
    ?>
</nav>