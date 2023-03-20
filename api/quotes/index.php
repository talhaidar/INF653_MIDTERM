<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    }
    
    $filterId = filter_input(INPUT_GET, "id");
    $filterAuthorId = filter_input(INPUT_GET, "authorId");
    $filterCategoryId = filter_input(INPUT_GET, "categoryId");

    
    if (!empty($filterId) && $method == 'GET') {
        include 'read_single.php';
    } elseif (!empty($filterAuthorId) && $method == 'GET') {
        include 'read_authorId.php';
    } elseif (!empty($filterCategoryId) && $method == 'GET') {
        include 'read_categoryId.php';
    } elseif (!empty($filterAuthorId) && !empty($filterCategoryId) && $method == 'GET') {
        include 'read_authorId_categoryId.php';
    } elseif ($method == 'POST') {
        include 'create.php';
    } elseif ($method == 'PUT') {
        include 'update.php';
    } elseif ($method == 'DELETE') {
        include 'delete.php';
    } elseif ($method == 'GET') {
        include 'read.php';
    }
