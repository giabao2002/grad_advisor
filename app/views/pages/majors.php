<?php
require_once "app/controller/MajorsController.php";

$majorsController = new MajorsController($conn);

$page = isset($_GET['num']) ? (int)$_GET['num'] : 1;
$page = max($page, 1);
$limit = 10; // Số lượng sinh viên mỗi trang
$offset = ($page - 1) * $limit;

$majors = $majorsController->index($limit, $offset);
$total_majors = $majorsController->count();
$total_pages = ceil($total_majors / $limit);
?>

<nav aria-label="Page navigation example">
    <button type="button" class="btn btn-primary float-end d-flex align-items-center ms-2" data-bs-toggle="modal" data-bs-target="#addMajorModal"><i class="material-icons">add</i> Thêm chuyên ngành</button>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Mã chuyên ngành</th>
                <th scope="col">Tên chuyên ngành</th>
                <th scope="col">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($majors as $index => $major): ?>
                <tr>
                    <th scope="row"><?php echo $index + 1; ?></th>
                    <td><?php echo htmlspecialchars($major['major_code']); ?></td>
                    <td class="col-2"><?php echo htmlspecialchars($major['major_name']); ?></td>
                    <td>
                        <form action="app/controller/MajorsController.php" method="POST" style="display:inline;">
                            <input type="hidden" name="action" value="destroy">
                            <input type="hidden" name="id" value="<?php echo $major['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm"><i class="material-icons">delete</i></button>
                        </form>
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
    <?php
    $modalId = "addMajorModal";
    $modalLabelId = "addMajorModalLabel";
    $modalTitle = "Thêm chuyên ngành";
    $formAction = "/app/controller/MajorsController.php";
    $formId = "addMajorForm";
    $formContent = '
        <input type="hidden" name="action" value="store">
        <div class="mb-3">
            <label for="student_code" class="form-label">Mã chuyên ngành</label>
            <input type="text" class="form-control" id="major_code" placeholder="Nhập mã chuyên ngành" name="major_code" required>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Tên chuyên ngành</label>
            <input type="text" class="form-control" id="name" placeholder="Nhập tên chuyên ngành" name="major_name" required>
        </div>';
    include 'app/views/components/modal.php';
    ?>
</nav>