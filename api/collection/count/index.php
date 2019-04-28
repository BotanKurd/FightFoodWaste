<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../../vendor/autoload.php";
require_once "../../token/utils.php";
require_once "../../utils/index.php";
require_once "../../pattern/index.php";


$REQUIRED_FIELDS = [
    'collection' => JSON_STRING,
    'query' => JSON_ARRAY,
    'token' => JSON_STRING
];

$input = json_decode(file_get_contents('php://input'), TRUE);

if (!checkFields($REQUIRED_FIELDS, $input)) {
    http_response_code(404);
    return;
}


if (!($_id = isValidToken($input['token']))) {
    http_response_code(401);
    return;
}

$collection = (new MongoDB\Client)->ffw->selectCollection($input['collection']);

echo $collection->countDocuments($input['query'], []);

