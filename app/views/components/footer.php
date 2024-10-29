<footer>
    <p>&copy; 2024 My Website. All rights reserved.</p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mở modal edit của page quản lý sinh viên
        var editStudentModal = document.getElementById('editStudentModal');
        if (editStudentModal) {
            editStudentModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget; // Nút kích hoạt modal
                var id = button.getAttribute('data-id');
                var student_code = button.getAttribute('data-student_code');
                var full_name = button.getAttribute('data-full_name');
                var dob = button.getAttribute('data-dob');
                var identity = button.getAttribute('data-identity');
                var address = button.getAttribute('data-address');
                var gender = button.getAttribute('data-gender');
                var email = button.getAttribute('data-email');
                var major = button.getAttribute('data-major');

                // Điền thông tin vào các trường trong form
                var modal = this;
                modal.querySelector('#id').value = id;
                modal.querySelector('#student_code').value = student_code;
                modal.querySelector('#full_name').value = full_name;
                modal.querySelector('#dob').value = dob;
                modal.querySelector('#identity').value = identity;
                modal.querySelector('#address').value = address;
                modal.querySelector('#gender').value = gender;
                modal.querySelector('#email').value = email;
                modal.querySelector('#major').value = major;
            });
        }

        // Mở modal edit của page quản lý học phần
        var editCourseModal = document.getElementById('editCourseModal');
        if (editCourseModal) {
            editCourseModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget; // Nút kích hoạt modal
                var id = button.getAttribute('data-id');
                var course_code = button.getAttribute('data-course_code');
                var course_name = button.getAttribute('data-course_name');
                var optional = button.getAttribute('data-optional');
                var credits = button.getAttribute('data-credits');
                var pre_course = button.getAttribute('data-pre_course');

                // Điền thông tin vào các trường trong form
                var modal = this;
                modal.querySelector('#id').value = id;
                modal.querySelector('#course_code').value = course_code;
                modal.querySelector('#course_name').value = course_name;
                modal.querySelector('#credits').value = credits;
                modal.querySelector('#optional').value = optional;
                modal.querySelector('#optional').checked = optional == 1;
                modal.querySelector('#pre_course').value = pre_course;
            });
        }

        // Lấy khóa học đã chọn
        var courseSelect = document.getElementById('courseSelect');

        courseSelect && courseSelect.addEventListener('change', function() {
            var selectedValue = courseSelect.value;
            console.log('Selected course ID:', selectedValue);

            window.location.href = '?page=grades&course=' + selectedValue;
        });

        var graduateSelect = document.getElementById('graduateSelect');

        graduateSelect && graduateSelect.addEventListener('change', function() {
            var selectedValue = graduateSelect.value;
            console.log('Selected graduate ID:', selectedValue);
            window.location.href = '?page=graduate&status=' + selectedValue;
        });

        var modal = document.getElementById('<?php echo $modalId; ?>');
        var form = document.getElementById('<?php echo $formId; ?>');
        var gradeFieldsContainer = document.getElementById('gradeFieldsContainer');

        // Đặt lại form khi modal bị đóng
        modal.addEventListener('hidden.bs.modal', function() {
            form.reset();
            gradeFieldsContainer.innerHTML = ''; // Xóa các trường điểm đã thêm
        });
    });

    //Thêm input form quản lý điểm
    var addCourseButton = document.getElementById('addGradeButton');
    var gradeFieldsContainer = document.getElementById('gradeFieldsContainer');

    addCourseButton && addCourseButton.addEventListener('click', function() {
        // Tạo một hàng mới
        var row = document.createElement('div');
        row.className = 'row mb-2';

        // Tạo cột cho thẻ select và label
        var selectCol = document.createElement('div');
        selectCol.className = 'col-5';

        // Tạo label cho thẻ select
        var selectLabel = document.createElement('label');
        selectLabel.textContent = 'Chọn học phần';
        selectLabel.className = 'form-label';

        // Tạo thẻ select cho học phần
        var select = document.createElement('select');
        select.className = 'form-control';
        select.name = 'courses[]';
        select.required = true;

        // Lấy danh sách các học phần đã được chọn
        var selectedCourses = Array.from(document.querySelectorAll('select[name="courses[]"]'))
            .map(function(select) {
                return select.value;
            });
        // Thêm các tùy chọn vào thẻ select
        <?php
        // Danh sách các học phần trong biến $courses
        if (isset($courses)) {
            foreach ($courses as $course) {
                echo "if (!selectedCourses.includes('{$course['course_code']}')) {";
                echo "var option = document.createElement('option');";
                echo "option.value = '{$course['course_code']}';";
                echo "option.text = '{$course['course_name']}';";
                echo "select.appendChild(option);";
                echo "}";
            }
        }
        ?>
        selectCol.appendChild(selectLabel);
        selectCol.appendChild(select);

        // Tạo cột cho thẻ input và label
        var inputCol = document.createElement('div');
        inputCol.className = 'col-5';

        // Tạo label cho thẻ input
        var inputLabel = document.createElement('label');
        inputLabel.textContent = 'Nhập điểm';
        inputLabel.className = 'form-label';

        // Tạo thẻ input cho điểm
        var input = document.createElement('input');
        input.type = 'number';
        input.className = 'form-control';
        input.name = 'grades[]';
        input.placeholder = 'Nhập điểm';
        input.required = true;

        inputCol.appendChild(inputLabel);
        inputCol.appendChild(input);

        // Tạo cột cho nút xóa
        var deleteCol = document.createElement('div');
        deleteCol.className = 'col-2 d-flex align-items-end';

        // Tạo nút xóa
        var deleteButton = document.createElement('button');
        deleteButton.type = 'button';
        deleteButton.className = 'btn btn-danger';
        deleteButton.textContent = 'Xóa';

        // Gắn sự kiện click cho nút xóa
        deleteButton.addEventListener('click', function() {
            gradeFieldsContainer.removeChild(row);
        });

        deleteCol.appendChild(deleteButton);

        // Thêm các cột vào hàng
        row.appendChild(selectCol);
        row.appendChild(inputCol);
        row.appendChild(deleteCol);

        // Thêm hàng vào container
        gradeFieldsContainer.appendChild(row);
    });
</script>
</body>

</html>