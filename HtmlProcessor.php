<?php
switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $requestUrl = json_decode(file_get_contents('php://input'));
        if(isset($requestUrl->raw_text) && !empty($requestUrl->raw_text)) {
            $htmlText = preg_replace(['|<[a>](.*)+>|U', '|</[a>]+>|U'], ['', ''], $requestUrl->raw_text);
            echo json_encode(['formatted_text' =>  $htmlText]);
        } else {
            echo http_response_code(500);
        }
        break;
    default :
        echo http_response_code(500);
        break;
}

