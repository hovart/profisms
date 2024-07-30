<?php
function msdt2strdt($msdt) {
    $num = $msdt;

    $days = floor($num);
    $part = $num - $days;

    $num = 24 * $part;
    $hr = floor($num);
    $part = $num - $hr;

    $num = 60 * $part;
    $min = floor($num);
    $part = $num - $min;

    $num = 60 * $part;
    $sec = round($num);
    $part = $num - $sec;

    $ff = strtotime("+$days days", strtotime("1899-12-30 00:00:00"));
    $ff = strtotime("1899-12-30 00:00:00");
    $ff = strtotime("2011-12-30 00:00:00");
    return sprintf("%s %02d:%02d:%02d", date("Y-m-d", strtotime("+$days days", strtotime("1899-12-30 00:00:00"))), $hr, $min, $sec);

}

function getInt($key, $default = 0){
    if (isset($_GET[$key])) {
        $value = filter_var($_GET[$key], FILTER_VALIDATE_INT);
        if ($value !== false) {
            return $value;
        }
    }
    return $default;
}

function getArray($key, array $default = []){
    if (isset($_POST[$key])) {
        $value = $_POST[$key];
        if (is_array($value)) {
            return $value;
        } elseif (is_string($value)) {
            return explode(',', $value);
        }
    }
    return $default;
}


function getString($key, $default = '')
{
    if (isset($_POST[$key])) {
        return htmlspecialchars((string) $_POST[$key], ENT_QUOTES, 'UTF-8');
    }
    return htmlspecialchars((string) $default, ENT_QUOTES, 'UTF-8');
}

function arrayAsCSV(array $array, $delimiter = ',', $enclosure = '"', $escapeChar = '\\') {
    $csv = '';
    $handle = fopen('php://temp', 'r+');

    foreach ($array as $row) {
        // Make sure the row is an array
        if (!is_array($row)) {
            $row = [$row];
        }
        fputcsv($handle, $row, $delimiter, $enclosure, $escapeChar);
    }

    rewind($handle);
    $csv = stream_get_contents($handle);
    fclose($handle);

    return $csv;
}

function is_valid_date_format($date) {
    $format = 'Y-m-d H:i:s';
    $d = DateTime::createFromFormat($format, $date);
    // Check if the date matches the format and is a valid date
    return $d && $d->format($format) === $date;
}

function convert_date_format($date) {
    $format = 'Y-m-d H:i:s';
    $dateObj = new DateTime($date);

    return $dateObj->format($format);
}

function is_valid_date($date) {
    return strtotime($date) >= strtotime('today');
}

function randomHash($length = 8) {
    $bytes = random_bytes(ceil($length / 2));
    return substr(bin2hex($bytes), 0, $length);
}