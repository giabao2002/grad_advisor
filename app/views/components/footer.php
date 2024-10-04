<footer>
    <p>&copy; 2024 My Website. All rights reserved.</p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var editStudentModal = document.getElementById('editStudentModal');
        if (editStudentModal) {
            editStudentModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget; // Nút kích hoạt modal
                var id = button.getAttribute('data-id');
                var student_code = button.getAttribute('data-student_code');
                var full_name = button.getAttribute('data-full_name');
                var dob = button.getAttribute('data-dob');
                var email = button.getAttribute('data-email');
                var major = button.getAttribute('data-major');

                // Điền thông tin vào các trường trong form
                var modal = this;
                modal.querySelector('#id').value = id;
                modal.querySelector('#student_code').value = student_code;
                modal.querySelector('#full_name').value = full_name;
                modal.querySelector('#dob').value = dob;
                modal.querySelector('#email').value = email;
                modal.querySelector('#major').value = major;
            });
        }

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
    });
</script>
</body>

</html>