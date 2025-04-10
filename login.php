<?php

include('db_conn.php');  // 데이터베이스 연결

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userid = $_POST['userid'];
    $passwd = $_POST['passwd'];

    // 사용자 정보 조회
    $sql = "SELECT * FROM users WHERE userid = '$userid'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    // 비밀번호 검증
    if ($user && password_verify($passwd, $user['passwd'])) { // 사용자가 있는지 암호화된 비밀번호, 쓴 비밀번호 비교
        $_SESSION['userid'] = $user['userid'];  // 세션에 로그인 정보 저장
        $_SESSION['user_id'] = $user['id'];  // 사용자 id를 세션에 저장
        header("Location: index.php");  // index.php로 리다이렉트
        exit();  // 코드 실행 중단
    } else {
        echo "<script>alert('아이디 또는 비밀번호가 틀렸습니다.');</script>";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>로그인</title>
    <link rel="stylesheet" href="CSS\login.css">
</head>
<body>
    <div class="form-container">
        <h1 class="form-title">로그인</h1>
        <form action="login.php" method="POST" class="login-form">
            <input type="text" name="userid" placeholder="아이디" required><br>
            <input type="password" name="passwd" placeholder="비밀번호" required><br>
            <button type="submit" class="submit-button">로그인</button>
        </form>
        <p class="form-footer">회원이 아니신가요? <a href="signUp.php">회원가입</a></p>
    </div>
</body>
</html>