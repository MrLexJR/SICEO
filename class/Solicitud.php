<?php
require 'Bd_function.php';
function acepta($Comentario, $Persona){
    $body = 'Estimado '.$Persona['Nombres'].': El permiso '.$Persona['Tipo'].' fue Aceptado con Fecha de Inicio: '.$Persona['FechaInicio'].' hasta: '.$Persona['FechaFin'] ;
    $estado = '3';
    $dias = 0;
    $consultar = "SELECT * FROM tbl_seccion WHERE id_seccion = ?";
    $resultado = Database::getInstance()->getDb()->prepare($consultar);
    $resultado->execute(array($Persona['id_seccion'])); //obtiene los id de la consulta
    $tabla = $resultado->fetch(PDO::FETCH_ASSOC);

    if($tabla['id_articulo']=='6'){
        $dias = $tabla['dias'];        
    }elseif($tabla['id_articulo']=='7'){
        $dateTimestamp1 = strtotime($Persona['FechaInicio']); 
        $dateTimestamp2 = strtotime($Persona['FechaFin']);
        $timeleft = $dateTimestamp2-$dateTimestamp1;
        $dias = round((($timeleft/24)/60)/60);     
    }

    $array=Solicitudes::Solicitud($estado ,$Persona['Id_Permisos'],$Persona['Id_Usuario'],$dias,$Comentario); 
    if($array){
        echo json_encode(array( 'status' => '200', 'msg' => $array ));
    }
    else {
        echo json_encode(array( 'status' => '400', 'msg' =>'Data Update Successfully'));
        enviaNotificacion($Persona['Id_Usuario'],$body);
    }
}

function niega($Comentario, $Persona){
    $body = 'Estimado '.$Persona['Nombres'].': El permiso '.$Persona['Tipo'].' NO fue Aceptado. Descripcion: '.$Comentario ;
    $estado = '4';
    $dias = 0;
    $array=Solicitudes::Solicitud($estado ,$Persona['Id_Permisos'],$Persona['Id_Usuario'],$dias,$Comentario); 
    if($array){
        echo json_encode(array( 'status' => '200', 'msg' => $array ));
    }
    else {
        echo json_encode(array( 'status' => '400', 'msg' =>'Data Update Successfully'));
        enviaNotificacion($Persona['Id_Usuario'],$body);
    }
}

function updPresentPermiso($Dia, $Persona){
    $array=Solicitudes::SolicitudCulmin($Dia ,$Persona['Id_Permisos']); 
    if($array){
        echo json_encode(array( 'status' => '200', 'msg' => $array ));
    }
    else {
        echo json_encode(array( 'status' => '400', 'msg' =>'Data Update Successfully'));
    }
}

function getSolicitudesAcep(){
    $consultar = "SELECT * FROM view_solicitudes_aceptadas;";
    $resultado = Database::getInstance()->getDb()->prepare($consultar);
    $resultado->execute();
    $tabla2 = "";
    $est = "";
    $class_td = "";
    while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
        $date = strtotime(date('Y-m-d')); 
        $dateTimestamp1 = strtotime($row['FechaInicio']); 
        $dateTimestamp2 = strtotime($row['FechaFin']);
        $timeleft = $dateTimestamp2-$date;
        $daysleft = round((($timeleft/24)/60)/60); 
        if ($dateTimestamp2 >= $date && $dateTimestamp1 <= $date)  
            $est = ' <span class=\"green-text text-darken-2\"> En Proceso </span> '; 
        elseif($dateTimestamp2 < $date && $dateTimestamp1 < $date ) 
            $est = ' <span class=\"red-text text-darken-2\"> Culminado </span> '; 
        elseif($dateTimestamp1 > $date) 
            $est = ' <span class=\"yellow-text text-darken-2\"> Por Comenzar </span> ';        
        $opc = '<a tittle=\"Opciones\" href=\"#!\" onclick=\"infoAcep('.$row['Id_Permisos'].')\" id=\"genera-pdf\">  <i class=\"material-icons\" aria-hidden=\"true\">more_vert</i></a>';
        $pdf = '<a id=\"genera-pdf\" href=\"#!\" onclick=\"viewPdf('.$row['Id_Permisos'].')\"  title=\"Ver Documento\" ><i class=\"material-icons red-text\" aria-hidden=\"true\">picture_as_pdf</i></a>';
        $pre = '<a tittle=\"Opciones\" href=\"#!\" onclick=\"userPresen('.$row['Id_Permisos'].')\" id=\"present-user\">  <i class=\"material-icons green-text\" aria-hidden=\"true\">how_to_reg</i></a>';
        $tabla2.='{
            "cedula":"'.trim($row['Cedula']).'", 
            "name":"'.trim($row['Nombres']).'",
            "tipo":"'.trim($row['Tipo']).'",
            "desc":"'.trim($row['Descripcion']).'",
            "fechas":"'.trim($row['FechaInicio']).' / '.trim($row['FechaFin']).'",
            "est":"'.$est.'",
            "opc":"'.$opc.$pre.$pdf.'",
            "days":"'.$daysleft.'"
          },';
    }
    $tabla2 = substr($tabla2, 0, strlen($tabla2) - 1);
    echo '{"data":['.$tabla2.']}';
}

function getSolicitudesDeneg(){
    $consultar = "SELECT * FROM view_solicitudes_denegadas;";
    $resultado = Database::getInstance()->getDb()->prepare($consultar);
    $resultado->execute();
    $tabla2 = "";
    while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {

        $opc = '<a tittle=\"Opciones\" href=\"#!\" onclick=\"inforDene('.$row['Id_Permisos'].')\" id=\"genera-pdf\" title=\"Opciones\"><i class=\"material-icons\" aria-hidden=\"true\">more_vert</i></a>';
        $pdf = '<a id=\"genera-pdf\" href=\"#!\" onclick=\"viewPdf('.$row['Id_Permisos'].')\"  title=\"Ver Documento\" ><i class=\"material-icons red-text\" aria-hidden=\"true\">picture_as_pdf</i></a>';
        $tabla2.='{
            "cedula":"'.trim($row['Cedula']).'", 
            "name":"'.trim($row['Nombres']).'",
            "tipo":"'.trim($row['Tipo']).'",
            "desc":"'.trim($row['Descripcion']).'",
            "fechas":"'.trim($row['FechaInicio']).' / '.trim($row['FechaFin']).'",
            "opc":"'.$opc.$pdf.'"
          },';
    }
    $tabla2 = substr($tabla2, 0, strlen($tabla2) - 1);
    echo '{"data":['.$tabla2.']}';
}


function getSolicitudes(){
    $consultar = "SELECT * FROM view_solicitudes_pendientes;";
    $resultado = Database::getInstance()->getDb()->prepare($consultar);
    $resultado->execute();
    $tabla = "";
    while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
        $aceptar = '<a id=\"acepta-solic\" onclick=\"aceptarSolicitud('.$row['Id_Permisos'].')\"  title=\"Aceptar\" class=\"btn-small btn-floating blue \"><i class=\"material-icons\" aria-hidden=\"true\">check_circle</i></a>';
        $denegar = '<a id=\"niega-solic\" onclick=\"niegaSolicitud('.$row['Id_Permisos'].')\"  title=\"Denegar\" class=\"btn-small btn-floating red \"><i class=\"material-icons\" aria-hidden=\"true\">block</i></a>';
        $pdf = '<a id=\"genera-pdf\"  href=\"#!\" onclick=\"viewPdf('.$row['Id_Permisos'].')\"  title=\"Ver Documento\" class=\"btn-small btn-floating white \" ><i class=\"material-icons red-text\" aria-hidden=\"true\">picture_as_pdf</i></a>';
        $tabla.='{
            "cedula":"'.trim($row['Cedula']).'", 
            "name":"'.trim($row['Nombres']).'",
            "tipo":"'.trim($row['Tipo']).'",
            "desc":"'.trim($row['Descripcion']).'",
            "enviado":"'.trim($row['Enviado']).'",
            "fechas":"'.trim($row['FechaInicio']).' / '.trim($row['FechaFin']).'",
            "acciones":"'.$aceptar.$denegar.$pdf.'"
          },';
    }
    $tabla = substr($tabla, 0, strlen($tabla) - 1);
    echo '{"data":['.$tabla.']}';
}

function getSolicitudesCulmin(){
    $consultar = "SELECT * FROM view_solicitudes_culminada;";
    $resultado = Database::getInstance()->getDb()->prepare($consultar);
    $resultado->execute();
    $tabla2 = "";
    while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
        // $opc = '<a tittle=\"Opciones\" href=\"#!\" onclick=\"inforDene('.$row['Id_Permisos'].')\" id=\"genera-pdf\" title=\"Opciones\"><i class=\"material-icons\" aria-hidden=\"true\">more_vert</i></a>';
        $pdf = '<a id=\"genera-pdf\" href=\"#!\" onclick=\"viewPdf('.$row['Id_Permisos'].')\"  title=\"Ver Documento\" ><i class=\"material-icons red-text\" aria-hidden=\"true\">picture_as_pdf</i></a>';
        $tabla2.='{
            "cedula":"'.trim($row['Cedula']).'", 
            "name":"'.trim($row['Nombres']).'",
            "tipo":"'.trim($row['Tipo']).'",
            "desc":"'.trim($row['Descripcion']).'",
            "fechas":"'.trim($row['FechaInicio']).' / '.trim($row['FechaFin']).'",
            "fechaP":"'.trim($row['FechaPresentacion']).'",
            "opc":"'.$pdf.'"
          },';
    }
    $tabla2 = substr($tabla2, 0, strlen($tabla2) - 1);
    echo '{"data":['.$tabla2.']}';
}


function getSolicitudesAll(){
    $consultar = "SELECT * FROM view_all_solicitudes";
    $resultado = Database::getInstance()->getDb()->prepare($consultar);
    $resultado->execute();
    $rows = array();
    while ($r = $resultado->fetchAll(PDO::FETCH_ASSOC)) {
        $rows = $r;
    }
    echo json_encode($rows);
  }

 function getNotificacion(){
    $consultar = "SELECT * FROM view_notifaciones";
    $resultado = Database::getInstance()->getDb()->prepare($consultar);
    $resultado->execute();
    $rows = array();
    while ($r = $resultado->fetchAll(PDO::FETCH_ASSOC)) {
        $rows = $r;
    }
    echo json_encode($rows);
 }

function enviaNotificacion($IdUsuario,$body){
    $consultar = "SELECT token FROM tbl_token WHERE Id_usuario = ?";
    $resultado = Database::getInstance()->getDb()->prepare($consultar);
    $resultado->execute(array($IdUsuario)); //obtiene los id de la consulta
    $tabla = $resultado->fetch(PDO::FETCH_ASSOC);
    ignore_user_abort();
    ob_start();

    $url = 'https://fcm.googleapis.com/fcm/send';
    $Token = $tabla['token'];
    $fields = array('to' => $Token ,'notification' => array('body' => $body, 'title' => 'Policia Nacional Del Ecuador', 'sound'=>'default', 'icon'=>'R.drawable.policia', 'sound' =>'default'));
    define('GOOGLE_API_KEY', 'AIzaSyDwcqu0sSrDSbwRAcycp0dVCb8ZY89Ke3Q');
    $headers = array( 'Authorization:key='.GOOGLE_API_KEY, 'Content-Type: application/json');      
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
}

function NotificaPer(){
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $array = Persona::RegistrarPermiso($_POST["Id_Permisos"],$_POST["Detalle"],$_POST['Id_Usuario'],$_POST["FechaInicio"],
                    $_POST["Descripcion"],$_POST["Comentario"],$_POST["Id_Estado"],$_POST["Id_Tipo"],$_POST["Hace_Uso"],$_POST["Lugar"],$_POST["id_articulo"]);
        if ($array) {
            echo json_encode(array( 'status' => '200', 'msg' => $array ));
          } else {
            echo json_encode(array( 'status' => '400', 'msg' =>'Data Inserted Successfully'));
            enviaNotificacion($_POST['Id_Usuario'],$_POST['body']);
          }
    }
}

if (isset($_POST['action']) && function_exists($_POST['action'])) {
    $action = $_POST['action'];
    $Comentario = isset($_POST['coment']) ? $_POST['coment'] : 'Permiso Aceptado';
    $Persona= isset($_POST['pers']) ? $_POST['pers'] : '';
    $DiaPres = isset($_POST['diaP']) ? $_POST['diaP'] : null;
    switch( $action ) {
        case "acepta":{
           acepta($Comentario, $Persona);
        }break;
        case "niega":{
            niega($Comentario,$Persona);
        }break;
        case "getSolicitudes":{
            getSolicitudes();
        }break;
        case "getSolicitudesAcep":{
            getSolicitudesAcep();
        }break;
        case "getSolicitudesDeneg":{
            getSolicitudesDeneg();
        }break;
        case "getSolicitudesAll":{
            getSolicitudesAll();
        }break;
        case "NotificaPer":{
            NotificaPer();
        }break;
        case "getNotificacion":{
            getNotificacion();
        }break;
        case "updPresentPermiso":{
            updPresentPermiso($DiaPres,$Persona);
        }break;
        case "getSolicitudesCulmin":{
            getSolicitudesCulmin();
        }break;
        default: die('Access denied for this function!');
      }
}else{
    die('error');
}
?>