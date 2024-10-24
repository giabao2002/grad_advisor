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

        // Mở modal edit của page quản lý môn học
        var editCourseModal = document.getElementById('editCourseModal');
        if (editCourseModal) {
            editCourseModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget; // Nút kích hoạt modal
                var id = button.getAttribute('data-id');
                var course_code = button.getAttribute('data-course_code');
                var course_name = button.getAttribute('data-course_name');
                var semester = button.getAttribute('data-semester');
                var credits = button.getAttribute('data-credits');
                var year = button.getAttribute('data-year');
                var pre_course = button.getAttribute('data-pre_course');

                // Điền thông tin vào các trường trong form
                var modal = this;
                modal.querySelector('#id').value = id;
                modal.querySelector('#course_code').value = course_code;
                modal.querySelector('#course_name').value = course_name;
                modal.querySelector('#semester').value = semester;
                modal.querySelector('#year').value = year;
                modal.querySelector('#credits').value = credits;
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
        selectCol.className = 'col-6';

        // Tạo label cho thẻ select
        var selectLabel = document.createElement('label');
        selectLabel.textContent = 'Chọn môn học';
        selectLabel.className = 'form-label';

        // Tạo thẻ select cho môn học
        var select = document.createElement('select');
        select.className = 'form-control';
        select.name = 'courses[]';
        select.required = true;

        // Lấy danh sách các môn học đã được chọn
        var selectedCourses = Array.from(document.querySelectorAll('select[name="courses[]"]'))
            .map(function(select) {
                return select.value;
            });
        // Thêm các tùy chọn vào thẻ select
        <?php
        // Danh sách các môn học trong biến $courses
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
        inputCol.className = 'col-6';

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

        // Thêm các cột vào hàng
        row.appendChild(selectCol);
        row.appendChild(inputCol);

        // Thêm hàng vào container
        gradeFieldsContainer.appendChild(row);
    });
</script>
</body>

</html>