<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="/ShopProject/assets/css/login.css">
</head>
<body>

    <div class="login-container">
        <form id="loginForm" class="login-form">
            <h2>Đăng nhập hệ thống</h2>
            <div class="input-group">
                <label for="username">Tên đăng nhập</label>
                <input type="text" id="username" name="username" placeholder="Nhập tên đăng nhập" required>
            </div>
            <div class="input-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" required>
            </div>
            <button type="submit" class="login-button">Đăng nhập</button>
            <p class="forgot-password">
                <a href="#">Quên mật khẩu?</a>
            </p>
            <p class="signup-link">
                Bạn chưa có tài khoản? <a href="#">Đăng ký ngay</a>
            </p>
            <p id="loginMessage" class="message-text"></p>
        </form>
    </div>

    <script>
        // Đây là phần JavaScript đơn giản để xử lý form (ví dụ)
        $(document).ready(function() {
            $('#loginForm').on('submit', function(e) {
                e.preventDefault(); // Ngăn chặn form gửi đi mặc định

                const username = $('#username').val();
                const password = $('#password').val();
                const messageDiv = $('#loginMessage');
                  $.post("http://localhost/ShopProject/Admin/Login",
                    {
                        username:username,
                        password:password
                    },
                    function(status,data){
                       
                      
                            if(data["status"]=="error"){
                                 messageDiv.text(data["errors"]);
                                messageDiv.css('color', 'red');
                            }else{
                                 window.location.href = 'http://localhost/ShopProject/Admin';
                            }
                        
                    }
                )

                // Ví dụ kiểm tra đăng nhập đơn giản ở client-side
                if (username === 'admin' && password === '123') {
                    messageDiv.text('Đăng nhập thành công! Đang chuyển hướng...');
                    messageDiv.css('color', 'green');
                    // Thực tế: chuyển hướng đến trang quản trị hoặc xử lý AJAX
                    // window.location.href = '/Admin/dashboard';
                } else {
                    messageDiv.text('Tên đăng nhập hoặc mật khẩu không đúng.');
                    messageDiv.css('color', 'red');
                }
            });
        });
    </script>

</body>
</html>