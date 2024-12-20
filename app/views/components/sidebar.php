<div class="d-flex flex-column flex-shrink-0 p-3 bg-light position-static left-0" id="sidebar">
    <div class="offcanvas-body px-0">
        <p class="text-primary fw-bold fs-large h4"><?php echo $_SESSION['auth_user']['role'] == "GV" ? 'Giáo viên' : 'Cố vấn học tập';  ?></p>
        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-start" id="menu">
            <li class="nav-item my-2">
                <a href="?page=students" class="nav-link text-truncate d-flex align-items-center">
                    <i class="material-icons">person</i><span class="ms-1 d-none d-sm-inline fw-bold">Quản lý sinh viên</span>
                </a>
            </li>
            <?php if ($_SESSION['auth_user']['role'] == 'GV'): ?>
                <li class="nav-item my-2">
                    <a href="?page=courses" class="nav-link text-truncate d-flex align-items-center">
                        <i class="material-icons">book</i><span class="ms-1 d-none d-sm-inline fw-bold">Quản lý học phần</span> </a>
                </li>
                <li class="nav-item my-2">
                    <a href="?page=grades" class="nav-link text-truncate d-flex align-items-center">
                        <i class="material-icons">grade</i><span class="ms-1 d-none d-sm-inline fw-bold">Quản lý điểm</span></a>
                </li>
            <?php elseif ($_SESSION['auth_user']['role'] == 'CVHT'): ?>
                <li class="nav-item my-2">
                    <a href="?page=majors" class="nav-link text-truncate d-flex align-items-center">
                        <i class="material-icons">contacts</i><span class="ms-1 d-none d-sm-inline fw-bold">Quản lý chuyên ngành</span></a>
                </li>
                <li class="nav-item my-2">
                    <a href="?page=graduate" class="nav-link text-truncate d-flex align-items-center">
                        <i class="material-icons">book</i><span class="ms-1 d-none d-sm-inline fw-bold">Xét tốt nghiệp</span></a>
                </li>
                <li class="nav-item my-2">
                    <a href="?page=progress" class="nav-link text-truncate d-flex align-items-center">
                        <i class="material-icons">dns</i><span class="ms-1 d-none d-sm-inline fw-bold">Chương trình học</span></a>
                </li>
            <?php elseif ($_SESSION['auth_user']['role'] == 'ADMIN'): ?>
                <li class="nav-item my-2">
                    <a href="?page=courses" class="nav-link text-truncate d-flex align-items-center">
                        <i class="material-icons">book</i><span class="ms-1 d-none d-sm-inline fw-bold">Quản lý học phần</span> </a>
                </li>
                <li class="nav-item my-2">
                    <a href="?page=grades" class="nav-link text-truncate d-flex align-items-center">
                        <i class="material-icons">grade</i><span class="ms-1 d-none d-sm-inline fw-bold">Quản lý điểm</span></a>
                </li>
                <li class="nav-item my-2">
                    <a href="?page=majors" class="nav-link text-truncate d-flex align-items-center">
                        <i class="material-icons">contacts</i><span class="ms-1 d-none d-sm-inline fw-bold">Quản lý chuyên ngành</span></a>
                </li>
                <li class="nav-item my-2">
                    <a href="?page=graduate" class="nav-link text-truncate d-flex align-items-center">
                        <i class="material-icons">book</i><span class="ms-1 d-none d-sm-inline fw-bold">Xét tốt nghiệp</span></a>
                </li>
                <li class="nav-item my-2">
                    <a href="?page=progress" class="nav-link text-truncate d-flex align-items-center">
                        <i class="material-icons">dns</i><span class="ms-1 d-none d-sm-inline fw-bold">Chương trình học</span></a>
                </li>
                <li class="nav-item my-2">
                    <a href="?page=accounts" class="nav-link text-truncate d-flex align-items-center">
                        <i class="material-icons">account_circle</i><span class="ms-1 d-none d-sm-inline fw-bold">Quản lý người dùng</span></a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</div>