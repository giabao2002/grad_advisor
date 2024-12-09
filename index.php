<?php
session_start();
// require_once("./core/db_connect.php");

require_once("app/views/components/header.php");

// Mảng ánh xạ giữa các giá trị của tham số `page` và tên tiếng Việt tương ứng
$page_titles = [
    'grades' => 'Quản lý điểm',
    'courses' => 'Quản lý học phần',
    'students' => 'Quản lý sinh viên',
    'progress' => 'Tiến trình học tập',
    'detail' => 'Chi tiết sinh viên',
    'certificate' => 'Danh sách văn bằng',
    'graduate' => 'Xét tốt nghiệp',
    'majors' => 'Quản lý chuyên ngành',
    'accounts' => 'Quản lý người dùng'
];
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-3 p-0">
            <?php require_once("app/views/components/sidebar.php"); ?>
        </div>
        <div class="col-9 min-vh-100 py-3">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <?php if (isset($_GET['page']) && array_key_exists($_GET['page'], $page_titles)): ?>
                        <li class="breadcrumb-item active" aria-current="page">
                            <a href="?page=<?php
                                            if ($_GET['page'] === 'detail') {
                                                echo $_GET['page'] . '&student_code=' . $_GET['student_code'];
                                            } else {
                                                echo $_GET['page'];
                                            }
                                            ?>">
                                <?php echo $page_titles[$_GET['page']]; ?>
                            </a>
                        </li>
                    <?php endif; ?>
                </ol>
            </nav>
            <!-- End of Breadcrumb -->

            <?php
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
                $allowed_pages = ['grades', 'courses', 'students', 'progress', 'detail', 'graduate', 'majors', 'accounts'];
                if (in_array($page, $allowed_pages)) {
                    require_once("app/views/pages/{$page}.php");
                } else {
                    echo "Page not found.";
                }
            } else {
                require_once("app/views/pages/intro.php");
            }
            ?>
        </div>
    </div>
</div>
<?php
include("app/views/components/footer.php");
?>