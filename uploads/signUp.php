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
<!-- Code injected by live-server -->
<script>
	// <![CDATA[  <-- For SVG support
	if ('WebSocket' in window) {
		(function () {
			function refreshCSS() {
				var sheets = [].slice.call(document.getElementsByTagName("link"));
				var head = document.getElementsByTagName("head")[0];
				for (var i = 0; i < sheets.length; ++i) {
					var elem = sheets[i];
					var parent = elem.parentElement || head;
					parent.removeChild(elem);
					var rel = elem.rel;
					if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() == "stylesheet") {
						var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
						elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date().valueOf());
					}
					parent.appendChild(elem);
				}
			}
			var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
			var address = protocol + window.location.host + window.location.pathname + '/ws';
			var socket = new WebSocket(address);
			socket.onmessage = function (msg) {
				if (msg.data == 'reload') window.location.reload();
				else if (msg.data == 'refreshcss') refreshCSS();
			};
			if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
				console.log('Live reload enabled.');
				sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
			}
		})();
	}
	else {
		console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
	}
	// ]]>
</script>
</body>
</html>