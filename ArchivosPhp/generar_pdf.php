<?php
// require('PDF/fpdf.php');
require '../class/Bd_function.php';
require ('../resources/lib/PDF/fpdf.php');
//Datos que se necesitan
//$persona="Nestor Mendoza";
//$identi="1345695554";
$recibe="Jaime Enrique Salazar Montedeosca";
//$fecha_inicio="01 de mayo de 2019";
//$detalle="mi hijo Andree Sebastian Yazan Velazquez de 6 años de edad, se encuentra ingresado en el Hospital Verdi Cevallos Balda de esta ciudad de PORTOVIEJO, por presentar Prepucio Redundante Fimosis y Parafimosis CIE 10.N47X(Intervencion Quirurjica), el cual se encuentra bajo mi cuidado";
//$tipo_permiso="licencia con remuneracion";
//$titulo_articulo="Calamidad Domestica";
//$num_art="27";
$dependencia_art="Art 38 literal 4 del Reglamento de la LOSEP";
//$detalle_art="Por accidente que provoque imposibilidad Fisica o por enfermedad grave de los padres o hermanos de la o el servidor se concedera hasta 2 dias, que se justificara con la presentacion del correspondiente certificado medico, dentro de los 3 dias posteriores del reintrego a su puesto";
//$cargo="Cabo Primero de Policia";


class PDF extends FPDF {
// Cabecera de página
	function Header() {
		// Logo
		$this->Image('../resources/img/logo.jpg',10,6,20);
		$this->Image('../resources/img/logo_m_i.png',160,6,40);
		// Arial bold 15
		$this->SetFont('Arial','B',10);
		$this->Cell(0,15,'POLICIA NACIONAL DEL ECUADOR',0,0,'C');
		$this->Ln(5);
		$this->Cell(0,15,'ZONA N° 4 ',0,0,'C');
		$this->Ln(5);
		$this->Cell(0,20,'SUBZONA MANABÍ N° 13 - DISTRITO PORTOVIEJO',0,0,'C');
		$this->SetDrawColor(61,174,233);
		$this->SetLineWidth(1);
		$this->Line(10,30,200,30);
		$this->Ln(40);
	}

	// Pie de página
	function Footer(){
		// Posición: a 1,5 cm del final
		$this->SetY(-15);
		// Arial italic 8
		$this->SetFont('Arial','I',8);
		// Número de página
		$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}

}
	if($_SERVER['REQUEST_METHOD']=='GET'){
		if(Isset($_GET['id'])){ //pregunta si el id existe
			$identificador=$_GET['id'];
			$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			$Respuesta=Solicitudes::ObtenerTodosLosPermsiso($identificador); //llama a la funcion obtenerDatosporID de la clase registro
			if($Respuesta){ 
				$detalle=$Respuesta['Descripcion'];
				$fecha_envio=strtotime($Respuesta['FechaInicio']); // fecha de envio la solicitud
				$fecha_inicio=$Respuesta['FechaInicio'];
				$date1 = strtotime($fecha_inicio);
				$fecha = date('d',$date1)." de ".$meses[date('n',$date1)-1]. " del ".date('Y',$date1) ;
				$fecha2 = date('d',$fecha_envio)." de ".$meses[date('n',$fecha_envio)-1]. " del ".date('Y',$fecha_envio) ;
				$cedula=$Respuesta['Cedula'];
				$persona=$Respuesta['Nombre']." ".$Respuesta['ApellidoPaterno']." ".$Respuesta['ApellidoMaterno'];
				$tipo_permiso=$Respuesta['tipo_permiso'];
				$titulo_articulo=$Respuesta['Titulo'];
				$num_art=$Respuesta['art_numero'];
				$detalle_art=$Respuesta['art_numero'];
				$detalle_art=$Respuesta['descripsecc'];
				$cargo=$Respuesta['cargo'];
				$recibe=$Respuesta['Nombre_recibe']." ".$Respuesta['ApellidoP_recibe']." ".$Respuesta['ApellidoM_recibe'];
				$pdf = new PDF();
				$pdf->SetMargins(12, 5 , 12); 
				$pdf->AliasNbPages();
				$pdf->AddPage();
				$pdf->SetFont('Times','',12);
				$pdf->Cell( 0, 10, 'Portoviejo, '.$fecha2, 0, 0, 'R' ); 
				$pdf->Ln(10);
				$pdf->MultiCell(0,5,"Señor Coronel de Policia de E.M");
				$pdf->MultiCell(0,5,$recibe);
				$pdf->MultiCell(0,5,"JEFE DEL COMANDO DEL DISTRITO PORTOVIEJO");
				$pdf->MultiCell(0,5,"En su despacho");
				$pdf->Ln(10);
				$pdf->MultiCell(0,5,"Mi coronel");
				$pdf->Ln(10);
				$pdf->MultiCell(0,5,"Reciba un cordial saludo y deseando exito en las funciones encomendadas");
				$pdf->Ln(10);
				$pdf->MultiCell(0,5,'Con todo respeto me permito informar a ud que el dia '.$fecha.', '.$detalle.', con este antecedente me permito solicitar se digne autorizarme '.$tipo_permiso.' por '.$titulo_articulo.' al amparo del Art.'.$num_art.' y '.$dependencia_art.' "'.$detalle_art.'".');
				$pdf->Ln(10);
				$pdf->MultiCell(0,5,"Particular que pongo en su conocimiento.");
				$pdf->Ln(10);
				$pdf->MultiCell(0,5,"De Usted, muy atentamente");
				$pdf->MultiCell(0,5,"DIOS,PATRIA Y LIBERTAD");
				$pdf->Ln(40);
				$pdf->MultiCell(0,5,$persona);
				$pdf->MultiCell(0,5,$cargo);
				//$pdf->MultiCell(0,5,"SERVIDOR POLICIAL TECNICO OPERATIVO");
				//$pdf->MultiCell(0,5,"SERVICIO DE TRANSITO PORTOVIEJO");
				$pdf->MultiCell(0,5,'CC: '.$cedula);
				$fileName = 'SICEO_SOLICITUD_N_' . $identificador . '.pdf';
				$pdf->Output($fileName, "I");
			}else{ 
				//echo json_encode(array('resultado'=>'El usuario no tiene solicitudes'));
			}
		}else{
			//echo json_encode(array('resultado'=>'Falta el identificador'));
		}
	}	


?>