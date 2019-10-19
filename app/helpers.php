<?php

use Carbon\Carbon;

const LOG_FILE = "storage/logs/errors.log";

function isProdEnvionnement() {
    return APP_ENV != 'dev';
}

function isAjaxRequest() {
    return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ? true : false;
}

function printToLogs($message) {
    $date = Carbon::now()->toDateTimeString();
    error_log("[$date] $message\n", 3, LOG_FILE);
}

function contains($string, $substring) {
    return strpos($string, $substring) !== false;
}

function areExtensionsEnabled(array $extensions) {
    $areAllExtensionsEnabled = true;
    foreach ($extensions as $extension) {
        if (!extension_loaded($extension)) {
            echo "$extension extension is not enabled";
            $areAllExtensionsEnabled = false;
        }
    }
    return $areAllExtensionsEnabled;
}

function formatResponse($models) {
    $response = null;
    if(is_a($models, 'Illuminate\Database\Eloquent\Collection')) {
        $response = array_map(function ($model) {
            return decodeArrayIfNeeded($model);
        }, $models->toArray());
    } else {
        $response = decodeArrayIfNeeded($models->toArray());
    }
    return json_encode($response);
}

function decodeArrayIfNeeded($array) {
    return array_map(function ($property) {
        return decodeIfNeeded($property);
    }, $array);
}

function decodeIfNeeded($string) {
    return $_SERVER['SERVER_NAME'] != 'localhost' ? utf8_decode($string) : $string;
}