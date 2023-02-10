<?php
session_start();

function error($message) {
    $_SESSION["errors"][] = $message;
}

function getErrors() {
    return $_SESSION["errors"] ?? [];
}

function clearErrors() {
    $_SESSION["errors"] = [];   
}

function validateString($name, $value) {
    if (empty($value)) {
        error("Le champ $name est vide");
        return false;
    }
    return true;
}

function validateDecimal($name, $value) {
    
    return is_numeric($value);
}

function validateInteger($name, $value) {
    return is_numeric($value) && is_integer(+$value);
}