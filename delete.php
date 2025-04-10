<?php
include('db_conn.php');  // 데이터베이스 연결

$id = $_GET['id'];  // 게시글 ID

// 비밀번호 확인을 위한 폼 제출 처리
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $passwd = $_POST['passwd'];  // 폼에서 입력된 비밀번호

    // 비밀번호 확인
    $sql = "SELECT passwd FROM board WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result); // 연관 배열
    $stored_passwd = $row['passwd'];  // DB에서 가져온 비밀번호

    // 비밀번호가 일치하면 게시글 삭제
    if ($stored_passwd === $passwd) {
        // 게시글 삭제
        $sql = "DELETE FROM board WHERE id = $id";
        if (mysqli_query($conn, $sql)) {
            // 삭제 후 id 재정렬 (삭제된 id 값 이후 모든 게시글 id를 1씩 감소)
            $sql = "UPDATE board SET id = id - 1 WHERE id > $id";
            mysqli_query($conn, $sql);

            // AUTO_INCREMENT 값을 다시 맞추기
            $sql = "ALTER TABLE board AUTO_INCREMENT = 1";
            mysqli_query($conn, $sql);

            echo "<script>alert('게시글이 삭제되었습니다.'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('게시글 삭제에 실패했습니다.');</script>";
        }
    } else {
        echo "<script>alert('비밀번호가 일치하지 않습니다.');</script>";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시글 삭제</title>
    <link rel="stylesheet" href="CSS/delete.css"> 
</head>
<body>
    <div class="form-container">
        <h1 class="form-title">게시글 삭제</h1>
        <form action="delete.php?id=<?php echo $id; ?>" method="POST" class="delete-form">
            <input type="password" name="passwd" placeholder="비밀번호" required><br>
            <button type="submit" class="submit-button">삭제</button>
        </form>
    </div>
</body>
</html>
