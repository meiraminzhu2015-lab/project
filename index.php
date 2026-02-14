
<?php

session_start();
$pin = "1234";


if(isset($_POST['pin'])){
    if($_POST['pin'] === $pin){
        $_SESSION['logged'] = true;
    } else {
        $error = "Неверный PIN";
    }
}

if(!isset($_SESSION['logged'])){
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>AuraGuard — Вход</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-950 text-white flex items-center justify-center h-screen">
<form method="POST" class="bg-gray-900 p-6 rounded-2xl w-80">
    <h1 class="text-2xl font-bold mb-4 text-cyan-400">AuraGuard — Вход</h1>
    <input type="password" name="pin" placeholder="Введите PIN" class="w-full p-2 rounded mb-3 text-black">
    <?php if(isset($error)) echo "<p class='text-red-500 mb-2'>$error</p>"; ?>
    <button class="w-full bg-cyan-400 text-black py-2 rounded font-bold">Войти</button>
</form>
</body>
</html>
<?php
exit();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>AuraGuard 2.0</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-950 text-white min-h-screen flex flex-col">

<header class="flex justify-between items-center p-6 border-b border-gray-800">
    <h1 class="text-3xl font-bold text-cyan-400">AuraGuard 2.0</h1>
    <div class="flex items-center space-x-3">
        <span class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></span>
        <span class="text-green-400 font-semibold">СИСТЕМА АКТИВНА</span>
    </div>
</header>

<main class="flex-1 p-6 grid md:grid-cols-2 gap-6">

<div class="bg-gray-900 p-6 rounded-2xl text-center border border-cyan-400">
    <h2 class="text-xl mb-4 text-cyan-400">Шумомер</h2>
    <div id="noiseValue" class="text-6xl font-bold text-cyan-400">-- дБ</div>
    <p id="statusText" class="mt-3"></p>

    <h2 class="text-xl mt-6 mb-2 text-cyan-400">Безопасность</h2>
    <label class="flex items-center justify-center space-x-3 mt-2">
        <input type="checkbox" id="awayMode">
        <span>Режим: Вне дома</span>
    </label>
    <p>🚪 Дверь: <span id="doorStatus" class="text-green-400">Закрыта</span></p>
    <p>🚶 Движение: <span id="motionStatus" class="text-green-400">Не обнаружено</span></p>

    <div id="alertBox" class="mt-4 text-red-500 font-bold"></div>
</div>

<div class="bg-gray-900 p-6 rounded-2xl border border-gray-700 text-center">
    <h2 class="text-xl mb-4 text-cyan-400">Мини-камера</h2>
    <img src="camera.png" alt="Камера" class="rounded w-full">
</div>

<div class="md:col-span-2 bg-gray-900 p-6 rounded-2xl border border-gray-700">
    <h2 class="text-xl mb-4 text-cyan-400">Лента событий</h2>
    <div id="logs" class="text-gray-400 text-sm space-y-1"></div>
</div>

</main>

<footer class="p-6 border-t border-gray-800 flex justify-between">
    <button class="bg-red-600 px-6 py-3 rounded font-bold">🚨 SOS</button>
    <a href="report.php" class="bg-cyan-400 text-black px-6 py-3 rounded font-bold">Скачать отчёт</a>
</footer>

<script>
function updateDashboard(){
    const away = document.getElementById("awayMode").checked ? 1 : 0;
    fetch("save_log.php?away="+away)
        .then(res=>res.json())
        .then(data=>{
            document.getElementById("noiseValue").innerText = data.noise + " дБ";
            document.getElementById("statusText").innerText = data.status;
            document.getElementById("doorStatus").innerText = data.door;
            document.getElementById("motionStatus").innerText = data.motion;
            document.getElementById("logs").innerHTML = data.logs;
            document.getElementById("alertBox").innerText = data.alert ? "⚠ Тревога! Подозрительная активность!" : "";
        });
}


updateDashboard();

setInterval(updateDashboard, 5000);
</script>

</body>
</html>