<?php
require_once(__DIR__ . "/AutoLoader.php");

use IugoGameLib\Document\JsonDocumentEncoder;
use IugoGameLib\ErrorDocumentFactory;

function getRelativeTo($base, $path) {
    $baseComponents = explode("/", $base);
    $pathComponents = explode("/", $path);
    
    for($i = 0; $i < count($baseComponents) && $i < count($pathComponents); $i++) {
        if($baseComponents[$i] == $pathComponents[$i]) {
            unset($pathComponents[$i]);
        } else
            break;
    }
    
    return join("/", $pathComponents);
}

$resource = getRelativeTo(dirname(filter_input(INPUT_SERVER, "PHP_SELF")), filter_input(INPUT_SERVER, "REQUEST_URI"));

switch($resource) {
    case "Timestamp":
        (new Timestamp())->execute();
        break;
    case "ScorePost":
        (new ScorePost())->execute();
        break;
    case "LeaderboardGet":
        (new LeaderboardGet())->execute();
        break;
    case "Transaction":
        (new Transaction())->execute();
        break;
    case "TransactionStats":
        (new TransactionStats())->execute();
        break;
    case "UserLoad":
        (new UserLoad())->execute();
        break;
    case "UserSave":
        (new UserSave())->execute();
        break;
    default:
        header('Content-Type: application/json');
        $encoder = new JsonDocumentEncoder();
        echo $encoder->encode((new ErrorDocumentFactory())->create("Invalid endpoint accessed"));
}