<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <style>
        * {
            padding: 0;
            margin: 0;
            font-family: "Roboto Mono", monospace;
        }

        section {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('../../public/image/backgroudnSign.jfif');
            background-repeat: no-repeat;
            background-size: cover;
        }

        article {
            width: 300px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            background-color: #fff;
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        }

        h3 {
            margin-bottom: 20px;
            color: #0B5ED7;
        }

        div {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <section>
        <article>
            <h3>Đăng nhập</h3>
            <form action="/app/controller/LoginController.php" method="POST">
                <div class="mb-3">
                    <label for="role">Vai trò</label><br />
                    <select name="role" class="form-select">
                        <option value="CVHT">Cố vấn học tập</option>
                        <option value="GV" selected>Giáo viên</option>
                        <option value="ADMIN">Quản trị viên</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="email">Email</label><br />
                    <input class="form-control" type="text" name="email" placeholder="Email">
                </div>
                <div class="mb-3">
                    <label for="password">Mật khẩu</label><br />
                    <input class="form-control" type="password" name="password" placeholder="Mật khẩu">
                </div>
                <button class="btn btn-primary" type="submit">Đăng nhập</button>
            </form>
            <?php if (isset($_GET['error'])): ?>
                <p style="color:red;font-size:small;margin-top:10px;"><?php echo htmlspecialchars($_GET['error']); ?></p>
            <?php endif; ?>
        </article>
    </section>
</body>

</html>