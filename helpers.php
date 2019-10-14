<?php

/**
 * Обрезает строку по кол-ву символов
 * @param $text
 * @param int $chars
 * @return false|string
 */
function truncate($text, $chars = 25) {
    if (strlen($text) <= $chars) {
        return $text;
    }
    $text = $text . " ";
    $text = substr($text,0, $chars);
    $text = substr($text,0, strrpos($text,' '));
    $text = $text . "...";

    return $text;
}


/**
 * Инициализирует запрос к заданной странице
 * @param $url
 * @return bool|string
 */
function request($url) {
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        die('Указан некорректный формат url!');
    }

    $headers = [
        'user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.111 Safari/537.36',
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}


/**
 * @return bool
 */
function isAjax() {
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        return true;
    }
    return false;
}


/**
 * Заменяет "опасные" символы
 * @param $data
 * @return mixed
 */
function encodeChars($data) {
    array_walk($data, function (&$item) {
        $item = htmlspecialchars($item);
    });
    return $data;
}