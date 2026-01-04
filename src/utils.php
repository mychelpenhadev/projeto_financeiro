<?php
// src/utils.php

function jsonResponse($data, $status = 200) {
    http_response_code($status);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function getJsonInput() {
    return json_decode(file_get_contents('php://input'), true);
}
?>
