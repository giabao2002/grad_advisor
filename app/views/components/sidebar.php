<div class="d-flex flex-column flex-shrink-0 p-3 bg-light" id="sidebar">
    <div class="offcanvas-body px-0">
        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-start" id="menu">
            <?php if ($_SESSION['auth_user']['role'] == 'GV'): ?>
                <li class="nav-item my-2">
                    <a href="?page=students" class="nav-link text-truncate d-flex align-items-center">
                        <i class="material-icons">person</i><span class="ms-1 d-none d-sm-inline fw-bold">Quản lý sinh viên</span>
                    </a>
                </li>
                <li class="nav-item my-2">
                    <a href="?page=courses" class="nav-link text-truncate d-flex align-items-center">
                        <i class="material-icons">book</i><span class="ms-1 d-none d-sm-inline fw-bold">Quản lý môn học</span> </a>
                </li>
                <li class="nav-item my-2">
                    <a href="?page=grades" class="nav-link text-truncate d-flex align-items-center">
                        <i class="material-icons">grade</i><span class="ms-1 d-none d-sm-inline fw-bold">Quản lý điểm</span></a>
                </li>
            <?php elseif ($_SESSION['auth_user']['role'] == 'CVHT'): ?>
                <li class="nav-item my-2">
                    <a href="?page=progress" class="nav-link text-truncate">
                        <i class="material-icons">linear_scale</i><span class="ms-1 d-none d-sm-inline fw-bold">Quản lý người dùng</span></a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</div>