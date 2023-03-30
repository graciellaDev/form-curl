<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<form class="form" method="POST" action="html_response_code.php" >
    <input class="form__input" name="url" type="text" placeholder="Введите урл" />
    <button class="form__btn" type="submit">
        Отправить
    </button>
</form>
</body>
</html>
<?php
    if (isset($_POST["url"])) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $_POST["url"]);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $content = curl_exec($curl);
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL,
                $_SERVER["HTTP_ORIGIN"] . mb_strrchr($_SERVER["SCRIPT_NAME"], '/', true) .
                '/HtmlProcessor.php');
            curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-type: application/json']);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $json_data = ['raw_text' => $content];
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($json_data, true));
            $response = curl_exec($curl);
            $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if($code != 500) {
                echo json_decode($response)->formatted_text;
            } else {
                echo '<p class="error">Ошибка получения контента</p>';
            }

    }
?>