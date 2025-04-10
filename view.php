<?php
session_start(); // 세션 시작
include('db_conn.php');  // 데이터베이스 연결

$id = $_GET['id'];  // 게시글 ID

// 로그인 여부 확인
if (!isset($_SESSION['userid'])) {
    echo "<script>alert('로그인 후 게시판 이용 가능합니다.'); window.location.href = 'login.php';</script>";
    exit;
}

// 게시글 조회수 증가
$sql = "UPDATE board SET views = views + 1 WHERE id = $id";
mysqli_query($conn, $sql);

// 게시글 데이터 가져오기
$sql = "SELECT * FROM board WHERE id = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result); // 연관 배열
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시글 상세</title>
    <link rel="stylesheet" href="CSS/view.css">
</head>
<body>
    <div class="board-container">
        <h1 class="board-title"><?php echo htmlspecialchars($row['title']); ?></h1> <!-- htmlspecialchars : 특수문자 안전하게 html로 변환 -->
        <p class="board-meta">작성자: <?php echo htmlspecialchars($row['userid']); ?></p>
        <p class="board-meta">작성일: <?php echo htmlspecialchars($row['regDate']); ?></p>
        <div class="board-content"><?php echo nl2br(htmlspecialchars($row['content'])); ?></div>

        <div class="board-file">
            <?php if ($row['file']): ?>
                <!-- 파일이 이미지일 경우 -->
                <?php 
                $file_ext = pathinfo($row['file'], PATHINFO_EXTENSION); // 파일 확장자 추출 
                if (in_array(strtolower($file_ext), ['jpg', 'jpeg', 'png', 'gif'])): ?> <!-- 특정 파일 확장자 포함 유무 -->
                    <img src="<?php echo htmlspecialchars($row['file']); ?>" alt="첨부 이미지" class="board-image">
                <?php else: ?>
                    <!-- 이미지가 아니면 다운로드 링크 제공 -->
                    <a href="<?php echo htmlspecialchars($row['file']); ?>" download class="file-download">첨부 파일 다운로드</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="board-buttons">
            <a href="write.php" class="write-button">새 글 작성</a>
            <a href="edit.php?id=<?php echo $id; ?>" class="action-button">글 수정</a>
            <a href="delete.php?id=<?php echo $id; ?>" class="action-button">글 삭제</a>
            <a href="index.php" class="action-button">목록으로</a>
        </div>
    </div>
</body>
</html>

<?php
// DB 연결 종료
mysqli_close($conn);
?>
