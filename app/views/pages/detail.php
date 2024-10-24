<?php
require_once "/xampp/htdocs/app/controller/DetailController.php";

$detailController = new DetailController($conn);

$student_code = $_GET['student_code'];
$students = $detailController->index($student_code);
$study_progress = $detailController->getCoursesTree($student_code);
?>
<nav aria-label="Page navigation">
    <div class="container overflow-hidden">
        <div class="row shadow-lg p-3 mb-5 bg-body rounded">
            <h5 class="bg-info p-2 text-light rounded">Thông tin sinh viên</h5>
            <div class="col-6 col-md-3 mt-2">
                <p class="fw-bold">Họ và tên:</p>
                <p class="fw-bold">Mã sinh viên:</p>
                <p class="fw-bold">CCCD/CMND:</p>
                <p class="fw-bold">Ngày sinh:</p>
                <p class="fw-bold">Giới tính:</p>
                <p class="fw-bold">Địa chỉ:</p>
                <p class="fw-bold">Ngành học:</p>
                <p class="fw-bold">Email:</p>
                <p class="fw-bold">Tình trạng:</p>
                <p class="fw-bold">Chứng chỉ ngoại ngữ:</p>
                <p class="fw-bold">Chứng chỉ tin học:</p>
                <p class="fw-bold">Chứng chỉ quân sự:</p>
                <p class="fw-bold">Tiến trình học tập:</p>
            </div>
            <div class="col-6 col-md-9 mt-2">
                <p><?php echo $students['full_name']; ?></p>
                <p><?php echo $students['student_code']; ?></p>
                <p><?php echo $students['identity']; ?></p>
                <p><?php
                    $dob = $students['dob'];
                    $formatted_dob = DateTime::createFromFormat('Y-m-d', $dob)->format('d/m/Y');
                    echo $formatted_dob; ?>
                </p>
                <p><?php echo $students['gender']; ?></p>
                <p><?php echo $students['address']; ?></p>
                <p><?php echo $students['major']; ?></p>
                <p><?php echo $students['email']; ?></p>
                <p class="<?php
                            if ($students['status'] == 'Đã tốt nghiệp') {
                                echo 'text-success';
                            } else if ($students['status'] == 'Thôi học  ') {
                                echo 'text-danger';
                            } else {
                                echo 'text-primary';
                            }
                            ?> fw-bold"><?php echo $students['status'] ?></p>
                <p class="d-flex">
                    <?php echo isset($students['language']) ? $students['language'] : "Chưa đạt"; ?>
                    <a type="button" href="/app/controller/GraduateController.php?cert=language&student_code=<?php echo $students['student_code']; ?>&status=<?php echo $students['language']; ?>"><i class="material-icons">autorenew</i></a>
                </p>
                <p class="d-flex">
                    <?php echo isset($students['infomatic']) ? $students['infomatic'] : "Chưa đạt"; ?>
                    <a type="button" href="/app/controller/GraduateController.php?cert=infomatic&student_code=<?php echo $students['student_code']; ?>&status=<?php echo $students['language']; ?>"><i class="material-icons">autorenew</i></a>
                </p>
                <p class="d-flex">
                    <?php echo isset($students['military']) ? $students['military'] : "Chưa đạt"; ?>
                    <a type="button" href="/app/controller/GraduateController.php?cert=military&student_code=<?php echo $students['student_code']; ?>&status=<?php echo $students['language']; ?>"><i class="material-icons">autorenew</i></a>
                </p>
                <p><?php echo $students['grade_courses_count'] . "/" . $students['total_courses_count']; ?></p>
            </div>
        </div>
        <div class="row shadow-lg p-3 mb-5 bg-body rounded">
            <h5 class="bg-info p-2 text-light rounded">Điểm học tập</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Môn học</th>
                        <th scope="col">Điểm hệ số 10</th>
                        <!-- <th scope="col">Điểm hệ số 4</th> -->
                        <th scope="col">Điểm chữ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students['course_grades'] as $index => $course_grade): ?>
                        <tr>
                            <th scope="row"><?php echo $index + 1; ?></th>
                            <td><?php echo htmlspecialchars($course_grade['course_name']); ?></td>
                            <td><?php echo htmlspecialchars($course_grade['grade']); ?></td>
                            <!-- <td><?php echo htmlspecialchars($course_grade['grade']); ?></td> -->
                            <td><?php
                                if ($course_grade['grade'] >= 9) {
                                    echo 'A';
                                } elseif ($course_grade['grade'] >= 8) {
                                    echo 'B';
                                } elseif ($course_grade['grade'] >= 6.5) {
                                    echo 'C';
                                } elseif ($course_grade['grade'] >= 5) {
                                    echo 'D';
                                } else {
                                    echo 'F';
                                }
                                ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="row shadow-lg p-3 mb-5 bg-body rounded">
            <h5 class="bg-info p-2 text-light rounded">Tiến trình học tập</h5>
            <?php include '/xampp/htdocs/app/views/components/progressTree.php'; ?>
        </div>
    </div>
</nav>