<head>
    <script src="resources/js/administ.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/css/dataTables.material.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/js/dataTables.material.min.js"></script>
    <link rel="stylesheet" href="http://cdn.shopify.com/s/files/1/1775/8583/t/1/assets/admin-materialize.min.css">
    <link rel="styleshett" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
    </link>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <link rel="styleshett" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
    </link>
</head>

<div class="row">
    <div class="card-panel s12 m12">
        <blockquote>
            <h2> Administración 
                <div class="right">

                    <!-- Dropdown Structure -->
                    <ul  class='tabs '>
                        <li class="tab"><a href="#tab_cargo">Cargos</a></li>
                        <li class="tab"><a href="#tab_notif">Notificaciones</a></li>
                        <!-- <li class="tab"><a href="#tab_licen">Licencias </a></li> -->
                        <!-- <li class="tab"><a href="#tab_artic">Articulos</a></li> -->
                    </ul>
                </div>  
            </h2>
        </blockquote>
    </div>

    <div id="tab_cargo" class="col s12">
        <div class="card-panel material-table">
            <div class="table-header">
                <span class="table-title">Cargos</span>  &emsp;
                <a title='Agregar' href='#modalCargo' id='nuevoCargo' class="btn-floating modal-trigger green"><i class='material-icons  white-text'>add</i></a>
                <div class="actions">
                    <a href="#!" class="search-toggle waves-effect btn-flat nopadding"><i
                            class="material-icons">search</i></a>
                </div>
            </div>
            <table id="table_cargo" class="mdl-data-table" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nombre de Grado</th>
                        <th>Descripcion</th>
                        <th>Cantidad de Personal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <div id="tab_notif" class="col s12">
        <div id="admin" class="col s12 m12">
            <div class="card-panel material-table">
                <div class="table-header">
                    <span class="table-title">Notificaciones </span>  &emsp;
                    <a title='Agregar' href='#modalNotifi' id='nuevaNotifi' class="btn-floating modal-trigger green"><i class='material-icons  white-text'>add</i></a>
                    <div class="actions">
                        <a href="#!" class="search-toggle waves-effect btn-flat nopadding"><i
                                class="material-icons">search</i></a>
                    </div>
                </div>
                <table id="table_notif" class="mdl-data-table" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Nombre </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>        
    </div>

   
    <div id="modalCargo" class="modal ">
        <div class="container">
            <div class="section center-align">
                <span id="titCargo" style="font-size:20px; font-weight: 100; font-family: sans-serif;"
                    class="black-text text-darken-4 header"></span>
                    <br /><br />
                <div class=" row">
                    <form id="formCargo">
                        <div class="col l12 m12 s12">
                            <input name="nCargo" id="nCargo" type="text" required="" aria-required="true">
                            <label for="nCargo">Nombre</label>
                        </div>
                        <div class=" col s12 m12 l12">
                            <textarea id="descri" class="materialize-textarea" data-length="120"></textarea>
                            <label for="descri">Descripcion</label>
                        </div>
                        <div class="input-field offset-s3 col s6">
                            <a class="modal-action modal-close waves-effect waves-green btn-flat">Cancelar</a>
                            <button class="btn waves-effect waves-light" type="submit" id="btn_aggCargo" >Enviar
                                <i class="material-icons right">send</i>
                            </button>
                            <a class="btn waves-effect waves-light green" id="btn_ediCargo" style="display: none;">Actualizar
                                <i class="material-icons right">send</i>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="modalNotifi" class="modal ">
        <div class="container">
            <div class="section center-align">
                <span id="titNotifi" style="font-size:20px; font-weight: 100; font-family: sans-serif;"
                    class="black-text text-darken-4 header"></span>
                    <br /><br />
                <div class="row">
                    <form id="formNotif">
                        <div class="col l12 m12 s12">
                            <input name="nNotif" id="nNotif" type="text" required="" aria-required="true">
                            <label for="nNotif">Nombre</label>
                        </div>
                        <div class="input-field offset-s3 col s6">
                            <a class="modal-action modal-close waves-effect waves-green btn-flat">Cancelar</a>
                            <button class="btn waves-effect waves-light" type="submit" id="btn_aggnotif" >Enviar
                                <i class="material-icons right">send</i>
                            </button>
                            <a class="btn waves-effect waves-light green" id="btn_ediNotif" style="display: none;">Actualizar
                                <i class="material-icons right">send</i>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</div>