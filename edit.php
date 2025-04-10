<?php
include('db_conn.php');  // 데이터베이스 연결

$id = $_GET['id'];  // 게시글 ID

// 게시글 정보 조회
$sql = "SELECT title, content, passwd, file FROM board WHERE id = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result); // 연관 배열
$title = $row['title'];
$content = $row['content'];
$stored_passwd = $row['passwd'];
$stored_file = $row['file'];  // 기존 파일

// 게시글 수정 시 비밀번호 확인
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $passwd = $_POST['passwd'];

    // 비밀번호 확인
    if ($stored_passwd === $passwd) {
        $new_title = $_POST['title'];
        $new_content = $_POST['content'];
        $new_file = $_FILES['file']['name'];  // 업로드된 파일 이름
        $file_path = $stored_file;  // 기존 파일을 덮어쓰지 않음

        // 파일이 첨부되었을 경우 처리
        if ($new_file) {
            // 파일 업로드 디렉토리 설정
            $target_dir = "uploads/";
            $file_path = $target_dir . basename($new_file);

            // 파일 크기 체크 (예: 최대 5MB)
            if ($_FILES["file"]["size"] > 5242880) {  // 5MB 제한
                echo "<script>alert('파일 크기를 초과했습니다. 5MB 이하로 업로드 해주세요.');</script>";
                exit;
            }

            // 기존 파일 삭제 (새 파일이 업로드되면)
            if ($stored_file && file_exists($stored_file)) {
                unlink($stored_file);
            }

            // 파일 업로드 처리
            if (!move_uploaded_file($_FILES["file"]["tmp_name"], $file_path)) {
                echo "<script>alert('파일 업로드에 실패했습니다.');</script>";
                exit;
            }
        }

        // 게시글 수정 쿼리
        $sql = "UPDATE board SET title = '$new_title', content = '$new_content', file = '$file_path' WHERE id = $id";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('게시글이 수정되었습니다.'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('게시글 수정에 실패했습니다.');</script>";
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
    <title>게시글 수정</title>
    <link rel="stylesheet" href="CSS/edit.css">
</head>
<body>
    <div class="form-container">
        <h1 class="form-title">게시글 수정</h1>
        <form action="edit.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data" class="edit-form">
            <input type="text" name="title" placeholder="제목" value="<?php echo htmlspecialchars($title); ?>" required><br>
            <textarea name="content" placeholder="내용" required><?php echo htmlspecialchars($content); ?></textarea><br>
            <input type="file" name="file"><br> <!-- 파일 첨부 입력란 -->
            <input type="password" name="passwd" placeholder="비밀번호" required><br>
            <button type="submit" class="submit-button">수정 완료</button>
        </form>
    </div>
</body>
</html>

