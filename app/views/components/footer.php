<footer>
    <p>&copy; 2024 My Website. All rights reserved.</p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var editModal = document.getElementById('editModal');
        editModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget; // Nút kích hoạt modal
            var id = button.getAttribute('data-id');
            var student_code = button.getAttribute('data-student_code');
            var full_name = button.getAttribute('data-full_name');
            var dob = button.getAttribute('data-dob');
            var email = button.getAttribute('data-email');
            var major = button.getAttribute('data-major');

            // Điền thông tin vào các trường trong form
            var modal = this;
            modal.querySelector('#edit-id').value = id;
            modal.querySelector('#edit-student_code').value = student_code;
            modal.querySelector('#edit-full_name').value = full_name;
            modal.querySelector('#edit-dob').value = dob;
            modal.querySelector('#edit-email').value = email;
            modal.querySelector('#edit-major').value = major;
        });
    });
</script>
</body>

</html>