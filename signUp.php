<?php
include('db_conn.php');  // 데이터베이스 연결

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userid = $_POST['userid'];
    $passwd = password_hash($_POST['passwd'], PASSWORD_DEFAULT);  // 비밀번호 암호화
    $email = $_POST['email'];
    $name = $_POST['name'];
    $tel = $_POST['tel'];

    // 회원가입 쿼리
    $sql = "INSERT INTO users (userid, passwd, email, name, tel) VALUES ('$userid', '$passwd', '$email', '$name', '$tel')";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('회원가입이 완료되었습니다.'); window.location.href = 'login.php';</script>";
    } else {
        echo "<script>alert('회원가입에 실패했습니다.');</script>";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>회원가입</title>
    <link rel="stylesheet" href="CSS/signUp.css">
</head>
<body>
    <div class="form-container">
        <h1 class="form-title">회원가입</h1>
        <form action="signUp.php" method="POST" class="signUp-form">
            <input type="text" name="userid" placeholder="아이디" required><br>
            <input type="password" name="passwd" placeholder="비밀번호" required><br>
            <input type="email" name="email" placeholder="이메일" required><br>
            <input type="text" name="name" placeholder="이름" required><br>
            <input type="text" name="tel" placeholder="전화번호" required><br>
            <button type="submit" class="submit-button">회원가입</button>
        </form>
        <p class="form-footer">이미 계정이 있으신가요? <a href="login.php">로그인</a></p>
    </div>
</body>
</html>