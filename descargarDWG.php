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

try {
    $RutaPlano = isset($_POST['_plano']) ?  $_POST['_plano'] : null;

    $resultado = str_replace("\\", "/", $RutaPlano);
    //echo "La cadena resultante es: " . $resultado;

    $RutaPlano = "/". $resultado;


    $file = $dropbox->download($RutaPlano);

    // $_Archivo_descarga = '/Iquique/Piping/Iq033revA.dwg';
    // $file = $dropbox->download($_Archivo_descarga);

    try {
        $archivotemporal = $dropbox->getTemporaryLink($RutaPlano);

        //print_r($archivotemporal); die;
        $metadata = $archivotemporal->getMetadata();
        $nombre = $metadata->getName();

        $link = $archivotemporal->getLink();
        echo $link;
    } catch (Throwable $th) {
        echo 'error';
    }
    

} catch (Throwable $t) {
    echo 'error';
}



?>