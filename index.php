<?php
include('db_conn.php');

// 게시글 목록 조회
$sql = "SELECT * FROM board ORDER BY regDate DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시글 목록</title>
    <link rel="stylesheet" href="CSS\index.css">
</head>
<body>
    <div class="board-container">
        <h1 class="board-title">게시글</h1>
        <a href="write.php" class="write-button">작성하기</a>
        <table class="board-table">
            <tr>
                <th>번호</th>
                <th>제목</th>
                <th>작성자</th>
                <th>작성일</th>
                <th>조회수</th>
            </tr>
            <?php while ($row = mysqli_fetch_array($result)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><a href='view.php?id=<?php echo $row['id']; ?>'><?php echo $row['title']; ?></a></td>
                <td><?php echo $row['userid']; ?></td>
                <td><?php echo $row['regDate']; ?></td>
                <td><?php echo $row['views']; ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>

<?php
mysqli_close($conn);
?>
