<?php
require_once "app/controller/MajorsController.php";                      
require_once "app/controller/ProgressController.php";  
$majorsController = new MajorsController($conn);
$progressController = new ProgressController($conn);

// Lấy tham số trang hiện tại từ URL, mặc định là trang 1
$page = isset($_GET['num']) ? (int)$_GET['num'] : 1;
$page = max($page, 1);
$limit = 10; 
$offset = ($page - 1) * $limit;

// Lấy danh sách chuyên ngành
$majors = $majorsController->index(null, null);
$major = isset($_GET['major']) ? $_GET['major'] : '';
$search = isset($_POST['search']) ? $_POST['search'] : '';

if ($search) {
    $courses = $progressController->search($search, $major);
    $total_courses = count($courses);
    $total_pages = 1;
} else {
    $courses = $progressController->index($limit, $offset, $major);
    $total_courses = $progressController->count($major);
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
    <input class="form-control form-control-sm mb-2" style="width: 385px;" name="major" id="majorSelect" list="majorPageList" placeholder="<?php echo $major ? htmlspecialchars($major) : 'Chọn chuyên ngành'; ?>">
    <datalist id="majorPageList">
        <option value=''>Chọn chuyên ngành</option>
        <?php foreach ($majors as $m): ?>
            <option value="<?php echo $m['major_code']; ?>">
                <?php echo htmlspecialchars($m['major_name']); ?>
            </option>
        <?php endforeach; ?>
    </datalist>
    <form class="d-flex float-start" method="post" style="height: 35px;">
        <input class="form-control-sm me-2" name="search" type="search" placeholder="Nhập mã học phần" aria-label="Search" required>
        <button class="btn btn-outline-success" type="submit" style="width:200px;">Tìm kiếm</button>
    </form>
    <button type="button" class="btn btn-warning float-end d-flex align-items-center text-white" data-bs-toggle="modal" data-bs-target="#importFileModal"><i class="material-icons">cloud_download</i> Nhập file</button>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Mã học phần</th>
                <th scope="col">Tên học phần</th>
                <th scope="col">Số tín chỉ</th>
                <th scope="col">Tùy chọn</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($courses as $index => $course): ?>
                <tr>
                    <th scope="row"><?php echo $index + 1; ?></th>
                    <td><?php echo htmlspecialchars($course['course_code']); ?></td>
                    <td class="col-2"><?php echo htmlspecialchars($course['course_name']); ?></td>
                    <td><?php echo htmlspecialchars($course['credits']); ?></td>
                    <td><?php echo $course['optional']; ?></td>
                    <td>
                        <form action="app/controller/ProgressController.php" method="POST" style="display:inline;">
                            <input type="hidden" name="action" value="destroy">
                            <input type="hidden" name="course_code" value="<?php echo $course['course_code']; ?>">
                            <input type="hidden" name="major_code" value="<?php echo $major; ?>">
                            <button type="submit" class="btn btn-danger btn-sm"><i class="material-icons">delete</i></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <ul class="pagination">
        <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
            <a class="page-link" href="?page=progress&num=<?php echo $page - 1; ?>&major=<?php echo $major ?>">Trước</a>
        </li>
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?php if ($page == $i) echo 'active'; ?>">
                <a class="page-link" href="?page=progress&num=<?php echo $i; ?>&major=<?php echo $major ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>
        <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
            <a class="page-link" href="?page=progress&num=<?php echo $page + 1; ?>&major=<?php echo $major ?>">Sau</a>
        </li>
    </ul>

    <?php
    $modalId = "importFileModal";
    $modalLabelId = "importFileModalLabel";
    $modalTitle = "Nhập thông tin từ file";
    $formAction = "/app/controller/ProgressController.php";
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