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

function validateRequired($name, $value, $option = []) {
    if (empty($value)) {
        error("Le champ $name est vide");
        return false;
    }
    return true;    
}

function validateString($name, $value, $option = []) {
    if (!validateRequired($name, $value)) {
        return false;
    }
    $minLength = $option["minLength"] ?? 0;
    if (strlen($value) < $minLength) {
        error("Le champ $name est trop court, le minimum est de $minLength caractères");
        return false;
    }
    $maxLength = $option["maxLength"] ?? 255;
    if (strlen($value)> $maxLength){
        error("le champs $name est trop long, le maximum est de $maxLength caractères");
        return false;
    }


    return true;
}

function validateDecimal($name, $value, $option = []) {
    if (!validateRequired($name, $value)){
        return false;
    }
    if(!is_numeric($value)){
        error("Le champ $name n'est pas un nombre valide");
        return false;
    }
    $minValue = $option["minValue"] ?? -INF;
    if ($value < $minValue) {
        error("Le champ $name est trop petit, le minimum est de $minValue");
        return false;
    }
    $maxValue = $option["maxValue"] ?? INF;
    if ($value> $maxValue){
        error("le champs $name est trop grand, le maximum est de $maxValue");
        return false;
    }

    return true;
}

function validateInteger($name, $value, $option = []) {
    if(!validateDecimal($name, $value, $option)){
        return false;
    }
    if(!is_integer(+$value)){
        error("Le champ $name n'est pas un nombre entier");
        return false;
    }
    return true;   
}