<?php

error_reporting(E_ALL ^ E_DEPRECATED);//Not ideal, but I'm new to this
require_once 'utils.php';
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
require __DIR__ . '/vendor/autoload.php';
$app = AppFactory::create();
//RECREATING A REACT APPLICATION IN LARAVEL

//use the 'any' and base endpoint for a more dynamic app:
$app->any('/', function (Request $request, Response $response, $args) {
    $uploadedFile=null;
    if ($request->getUploadedFiles()){    
        $uploadedFile = $request->getUploadedFiles()['file'];
    }
    if ($uploadedFile) {
        $fileContents = $uploadedFile->getStream()->getContents();
        $fileText =  htmlspecialchars($fileContents);
    } else {
        $fileText = '';
    }

    $html = <<<HTML
        <head>
            <title>Auto Redact with PHP</title>
            <link rel="stylesheet" href="/public/index.css">
        </head>
        <form action="/" method="post" enctype="multipart/form-data">
            <input type="file" name="file" accept=".txt">
            <button type="submit">Upload</button>
        </form>
        <form action="/" method="post" enctype="multipart/form-data">
            <input id='redacted-phrases' type="text" name="redacted-phrases" accept=".txt">
            <button type="submit">Upload</button>
        </form>
        <h2 >File Content:</h2>
        <p id='file-text'>$fileText</p>
    HTML;

    $response->getBody()->write($html);
    return $response->withHeader('Content-Type', 'text/html');
});

$app->run();
