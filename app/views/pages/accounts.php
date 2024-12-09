<?php
require_once "app/controller/UserController.php";
$userController = new UserController($conn);

// Lấy tham số trang hiện tại từ URL, mặc định là trang 1
$page = isset($_GET['num']) ? (int)$_GET['num'] : 1;
$page = max($page, 1);
$limit = 10; // Số lượng sinh viên mỗi trang
$offset = ($page - 1) * $limit;

$search = isset($_POST['search']) ? $_POST['search'] : '';
if ($search) {
    $users = $userController->show($search);
    $total_users = count($users);
    $total_pages = 1;
} else {
    $users = $userController->index($limit, $offset);
    $total_users = $userController->count();
    $total_pages = ceil($total_users / $limit);
}
?>

<nav aria-label="Page navigation">
    <?php if (isset($_GET['message'])): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?php echo $_GET['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <form class="d-flex float-start" method="post">
        <input class="form-control-sm me-2" name="search" type="search" placeholder="Nhập email" aria-label="Search" required>
        <button class="btn btn-outline-success mr-2" type="submit">Tìm kiếm</button>
    </form>
    <button type="button" class="btn btn-primary float-end d-flex align-items-center ms-2" data-bs-toggle="modal" data-bs-target="#addUserModal"><i class="material-icons">add</i> Thêm người dùng</button>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tên tài khoản</th>
                <th scope="col">Email</th>
                <th scope="col">Vai trò</th>
                <th scope="col">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $index => $user): ?>
                <tr>
                    <th scope="row"><?php echo $index + 1; ?></th>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php
                        if ($user['role'] === 'GV') {
                            echo htmlspecialchars('Giáo viên');
                        } else if ($user['role'] === 'CVHT') {
                            echo htmlspecialchars('Cố vấn học tập');
                        } else {
                            echo htmlspecialchars('Quản trị viên');
                        }
                        ?>
                    </td>
                    <td>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal"
                            data-id="<?php echo $user['id']; ?>"
                            data-username="<?php echo htmlspecialchars($user['username']); ?>"
                            data-email="<?php echo htmlspecialchars($user['email']); ?>"
                            data-password="<?php echo htmlspecialchars($user['password']); ?>"
                            data-role="<?php echo htmlspecialchars($user['role']); ?>">
                            <i class="material-icons">edit</i>
                        </button>
                        <?php if ($user['role'] !== 'ADMIN'): ?>
                            <form action="app/controller/UserController.php" method="POST" style="display:inline;">
                                <input type="hidden" name="action" value="destroy">
                                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm"><i class="material-icons">delete</i></button>
                            </form>
                        <?php endif; ?>
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
    $modalId = "addUserModal";
    $modalLabelId = "addUserModalLabel";
    $modalTitle = "Thêm sinh viên";
    $formAction = "/app/controller/UserController.php";
    $formId = "addUserForm";
    $formContent = '
        <input type="hidden" name="action" value="store">
        <div class="mb-3">
            <label for="username" class="form-label">Tên người dùng</label>
            <input type="text" class="form-control" id="username" placeholder="Nhập tên người dùng" name="username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu</label>
            <input type="password" class="form-control" id="password" placeholder="Nhập mật khẩu" name="password" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Vai trò</label>
            <select name="role" id="role" class="form-select" required>
                <option value="GV" selected>Giáo viên</option>
                <option value="CVHT">Cố vấn học tập</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" placeholder="name@example.com" name="email" required>
        </div>';
    include 'app/views/components/modal.php';
    ?>


    <?php
    $modalId = "editUserModal";
    $modalLabelId = "editUserModalLabel";
    $modalTitle = "Sửa thông tin người dùng";
    $formAction = "/app/controller/UserController.php";
    $formId = "editUserForm";
    $formContent = '
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="id" id="id">
        <div class="mb-3">
            <label for="username" class="form-label">Tên người dùng</label>
            <input type="text" class="form-control" id="username" placeholder="Nhập tên người dùng" name="username" required>
        </div>
        <div class="mb-3">
            <label for="oldPassword" class="form-label">Mật khẩu cũ</label>
            <input type="password" class="form-control" id="oldPassword" name="oldPassword" disabled>
        </div>
        <div class="mb-3">
            <label for="newPassword" class="form-label">Mật khẩu mới</label>
            <input type="password" class="form-control" id="newPassword" placeholder="Nhập mật khẩu" name="newPassword">
        </div>
        <div class="mb-3">
            <label for="confirmPassword" class="form-label">Nhập lại mật khẩu</label>
            <input type="password" class="form-control" id="confirmPassword" placeholder="Nhập mật khẩu" name="confirmPassword">
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Vai trò</label>
            <select name="role" id="role" class="form-select" required>
                <option value="GV" selected>Giáo viên</option>
                <option value="CVHT">Cố vấn học tập</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" placeholder="name@example.com" name="email" required>
        </div>';
    include 'app/views/components/modal.php';
    ?>
</nav>