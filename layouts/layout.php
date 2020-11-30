<!DOCTYPE html>
<html lang="es">

<head>
    <title>SICEO - Policia Nacional </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="SICEO">
    <link rel="shortcut icon" type="img/x-icon" href="resources/img/siceo_icon.ico">
    <link rel="stylesheet" type="text/css" href="resources/diseño/style.css">
    <link rel="stylesheet" type="text/css" href="resources/diseño/style_datable.css">
    <script  type="text/javascript" src="resources/js/notificacion.js"></script>
    <!-- jQuery library -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <!-- Icon Material CSS -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
</head>

<body>
    <?php  require_once('header.php'); ?>
    <main>
        <section>
            <div class="container">
                <?php if (isset($_GET['menu'])) { require_once('routing.php'); } else {?>
                <div class="row">
                    <div class="col s12 ">
                        <div class="card-panel ">
                            <div class="row">
                                <div class="col s12 m7">
                                    <div class="card">
                                        <div class="slider">
                                            <ul class="slides">
                                                <li>
                                                    <img class="activator" src="resources/img/Policia-2.jpg">
                                                    <!-- random image -->
                                                    <div class="caption left-align">
                                                        <h4>Policia Nacional del Ecuador</h4>
                                                        <h5 class="light grey-text text-lighten-3">Policia.</h5>
                                                    </div>
                                                </li>
                                                <li>
                                                    <img class="activator" src="resources/img/poli_2.jpg">
                                                    <!-- random image -->
                                                    <div class="caption left-align">
                                                        <h4>Policia Nacional del Ecuador</h4>
                                                        <h5 class="light grey-text text-lighten-3">Listos para servir.
                                                        </h5>
                                                    </div>
                                                </li>
                                                <li>
                                                    <img class="activator" src="resources/img/poli_5.jpg">
                                                    <!-- random image -->
                                                    <div class="caption left-align">
                                                        <h4>Policia Nacional del Ecuador</h4>
                                                        <h5 class="light grey-text text-lighten-3">Unidad de vigilancia
                                                            comunitaria.</h5>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="card-content">
                                            <span class="card-title activator blue-text text-darken-4">Policia Nacional
                                                Ecuador<i class="material-icons right">more_vert</i></span>
                                            <p><a href="https://www.policiaecuador.gob.ec">Pagina Oficial</a></p>
                                        </div>
                                        <div class="card-reveal">
                                            <span class="card-title grey-text text-darken-4"><i
                                                    class="material-icons right">close</i>INSTITUCION</span>
                                            <h4></h4>
                                            <p align="justify">Ser policía es, ante todo, una vocación de servicio
                                                público en el marco de un Estado de derechos. Es un compromiso con el
                                                bien común, con el desarrollo de nuestro país, con el bienestar de la
                                                sociedad y, sobre todo, con la existencia misma del Estado ecuatoriano
                                                en el contexto regional y mundial.

                                                La identidad policial es más que un reglamento de conducta, un manual de
                                                ética o una doctrina, es en esencia una práctica permanente acogida
                                                entre sus miembros y reflejada en su vida diaria. </p>
                                            <p align="justify">
                                                Por ello, quienes vestimos el uniforme de la Policía no podemos dejar de
                                                preguntarnos si nuestras acciones son justas, legales, correctas y
                                                éticas. Solo una conducta razonada, ética, transparente y responsable
                                                nos permitirá contar con la aceptación ciudadana necesaria para realizar
                                                de mejor forma nuestro trabajo. Ser policía es saber que somos parte de
                                                una noble institución que protege los derechos de todas las personas y
                                                colectivos legítimos y que reconoce a aquellos superiores que han sido
                                                ejemplo de mujeres y hombres disciplinados, honestos, valientes y
                                                sacrificados como seres humanos íntegros y capaces de dar su vida para
                                                honrar su juramento de servicio.</p>

                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m5 ">
                                    <div class="section">
                                        <div class="center-align">
                                            <span style="font-size:50px; font-weight: 100; font-family: sans-serif;" class="blue-text text-darken-4 header ">SICEO</span>
                                        </div>
                                        <div class="card blue ">
                                            <div class="card-content white-text">
                                                <p align="justify">Siceo es un sistema informático para el registro de novedades como licencias, permisos, Comisión ocasional, traslado temporal, cursos, control de los servidores policiales durante el uso de las novedades mencionadas, permitiendo al departamento de talento humano a través de este sistema observar mediante reportes los días transcurridos de las novedades registradas, permitiendo al asistente de talento humano llevar un control más eficiente de los servidores policiales de su jurisdicción. Todo esto con el objetivo final de facilitar los procesos de auditoría y control interno, mejorando de por sí el control de los servidores policiales en uso de las novedades registradas en este sistema.</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            </div>
        </section>
    </main>

    <footer class="page-footer blue"> <?php  include_once('footer.php'); ?> </footer>
</body>

</html>

<script type="text/javascript">

$(document).ready(function() {
    $('.slider').slider();
});
</script>