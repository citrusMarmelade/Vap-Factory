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

function validateRequired($name, $value) {
    if (empty($value)) {
        error("Le champ $name est vide");
        return false;
    }
    return true;    
}

function validateString($name, $value) {
    if (!validateRequired($name, $value)) {
        return false;
    }
    return true;
}

function validateDecimal($name, $value) {
    if (!validateRequired($name, $value)){
        return false;
    }
    if(!is_numeric($value)){
        error("Le champ $name n'est pas un nombre valide");
        return false;
    }

    return true;
}

function validateInteger($name, $value) {
    if(!validateDecimal($name, $value)){
        return false;
    }
    if(!is_integer(+$value)){
        error("Le champ $name n'est pas un nombre entier");
        return false;
    }
    return true;
    
}