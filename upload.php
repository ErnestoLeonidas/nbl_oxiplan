<?php

session_start();
require_once 'terceros/dropbox/vendor/autoload.php';
use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;

$dropboxKey ="jdwx3v55iue9wvd";
$dropboxSecret ="81lgkqitnhedgns";
$dropboxToken="2mraq71zE3AAAAAAAABSr8DSD7hiVzayd7ah7eKjGvoZd3LNNuqO4TsKx9Cxc7gm";

$app = new DropboxApp($dropboxKey,$dropboxSecret,$dropboxToken);
$dropbox = new Dropbox($app);

$RutaPlano = isset($_GET['_plano']) ?  $_GET['_plano'] : null;
$_Archivo_descarga = '/blablabla.jpg';

$file = $dropbox->download($_Archivo_descarga);

$archivotemporal = $dropbox->getTemporaryLink($_Archivo_descarga);

//print_r($archivotemporal); die;
$metadata = $archivotemporal->getMetadata();
$nombre = $metadata->getName();



$link = $archivotemporal->getLink();
print_r($link);





die;
//File Contents
$contents = $file->getContents();

//Save file contents to disk
//file_put_contents(__DIR__ . "/blablabla.jpg", $contents);

//Downloaded File Metadata
$metadata = $file->getMetadata();
//Name
$fileName = $metadata->getName();
$filePath = $metadata->getPathDisplay();


$valor = $metadata->getData();

$id = $metadata->getId();

print_r($file);

//https://www.dropbox.com/s/hwo2w0qa07mtpfi/blablabla.jpg?dl=0

?>