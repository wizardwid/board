<?php

include('db_conn.php');  // 데이터베이스 연결

if (!isset($_SESSION['userid'])) {
    echo "<script>alert('로그인 후 게시판 이용 가능합니다.'); window.location.href = 'login.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {  // POST 요청일 때만 실행
    $userid = $_SESSION['userid'];  // 세션에서 사용자 ID 가져오기
    $title = $_POST['title'];
    $content = $_POST['content'];
    $file = $_FILES['file']['name'];  // 첨부된 파일 이름
    $passwd = $_POST['passwd'];

    // 파일 업로드 처리
    $target_dir = "uploads/";

    // 첨부된 파일이 있을 경우
    if ($file) {
        $file_path = $target_dir . basename($file);

        // 업로드 파일 크기 체크
        if ($_FILES["file"]["size"] > 10485760) {
            echo "<script>alert('파일 크기가 너무 큽니다. 10MB 이하로 업로드 해주세요.');</script>";
            exit;
        }

        // 파일 업로드 처리
        if (!move_uploaded_file($_FILES["file"]["tmp_name"], $file_path)) {
            echo "<csript>alert('파일 업로드에 실패했습니다.');</csript>";
            exit;
        }
    } else {
        $file_path = NULL;  // 파일이 없으면 NULL로 설정
    }

    // 게시글 DB에 저장
    $sql = "INSERT INTO board (userid, title, content, file, passwd) 
            VALUES ('$userid', '$title', '$content', '$file_path', '$passwd')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('게시글이 작성되었습니다.'); window.location.href='index.php';</script>";
    } else {
        echo "<sript>alert('게시글 작성에 실패했습니다.');</sript> ";
    }

    // DB 연결 종료
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시글 작성</title>
    <link rel="stylesheet" href="CSS/write.css">
</head>
<body>
    <div class="form-container">
        <h1 class="board-title">게시글 작성</h1>
        <form action="write.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="userid" value="<?php echo $_SESSION['userid']; ?>" readonly><br> 
            <input type="text" name="title" placeholder="제목" required><br>
            <textarea name="content" placeholder="내용" required></textarea><br>
            <input type="file" name="file"><br>
            <input type="password" name="passwd" placeholder="비밀번호" required><br>
            <button type="submit">작성 완료</button>
        </form>
    </div>
</body>
</html>
