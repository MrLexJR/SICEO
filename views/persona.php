<head>
    <script src="resources/js/personal.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/css/dataTables.material.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/js/dataTables.material.min.js"></script>
    <link rel="stylesheet" href="http://cdn.shopify.com/s/files/1/1775/8583/t/1/assets/admin-materialize.min.css">
    <link rel="styleshett" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css"> </link>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <link rel="styleshett" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css"></link>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowreorder/1.2.5/css/rowReorder.dataTables.min.css">
    <script src="https://cdn.datatables.net/rowreorder/1.2.5/js/dataTables.rowReorder.min.js"></script>
    
</head>

<div class="row">
    <div class="card-panel">
        <blockquote>
            <h2> Personal</h2>
        </blockquote>
        <ul class="tabs">
            <li class="tab "><a href="#ingeso">Agregar Persona</a></li>
            <li class="tab "><a class="active" href="#lista">Lista de Persona</a></li>
        </ul>
    </div>

    <div id="ingeso" class="col m12 l12 s12 ">
        <div class="card-panel">
            <h4 class="header2">Datos </h4>
            <div class="row">
                <form method="post" id="savePersona" class="col m12 s12">
                    <div class="col s12 m12">
                        <div class="input-field col m12 l6 s6">
                            <i class="material-icons prefix">portrait</i>
                            <input name="cedula" id="cedula" type="text" maxlength="10" required=""
                                aria-required="true">
                            <label for="cedula">Cedula</label>
                        </div>
                        <div class="input-field col m12 l6 s6">
                            <i class="material-icons prefix">wc</i>
                            <select required="" id="genero">
                                <option value="" disabled selected>Genero</option>
                                <option value="MASCULINO">Masculino</option>
                                <option value="Femenino">Femenino</option>
                            </select>
                            <label for="genero">Genero</label>
                        </div>
                        <div class="input-field col l4 m4 s4">
                            <i class="material-icons prefix">account_circle</i>
                            <input onkeyup="javascript:this.value=this.value.toUpperCase();" name="nombres" id="nombres" type="text" required="" aria-required="true">
                            <label for="nombres">Nombres</label>
                        </div>
                        <div class="input-field col l4 m4 s4">
                            <input onkeyup="javascript:this.value=this.value.toUpperCase();" name="ap_paterno" id="ap_paterno" type="text" required="" aria-required="true">
                            <label for="ap_paterno">Apellido paterno</label>
                        </div>
                        <div class="input-field col l4 m4 s4">
                            <input onkeyup="javascript:this.value=this.value.toUpperCase();" name="ap_materno" id="ap_materno" type="text" required="" aria-required="true">
                            <label for="ap_materno">Apellido materno</label>
                        </div>
                        <div class="input-field col l6 m12 s6">
                            <i class="material-icons prefix"> email </i>
                            <input name="email" id="email" type="email" required="" aria-required="true">
                            <label for="email" data-error="ingrese correo valido">Correo</label>
                        </div>
                        <div class="input-field col l6 m12 s6">
                            <i class="material-icons prefix">phone</i>
                            <input name="telefo" id="telefo" type="text" maxlength="10" >
                            <label for="telefo">Telefoneo/Celular</label>
                        </div>
                        <div class="input-field col m12 l6 s6">
                            <i class="material-icons prefix">how_to_reg</i>
                            <select id="cargo" required>
                                <option value="" selected disabled>Cargo</option>
                            </select>
                            <label for="cargo">Cargo</label>
                        </div>
                        <div class="input-field col m12 l6 s6">
                            <i class="material-icons prefix">calendar_today</i>
                            <select id="mes" required>
                                <option value="" selected disabled>Mes</option>
                                <option value="1">Enero</option>
                                <option value="2">Febrero</option>
                                <option value="3">Marzo</option>
                                <option value="4">Abril</option>
                                <option value="5">Mayo</option>
                                <option value="6">Junio</option>
                                <option value="7">Julio</option>
                                <option value="8">Agosto</option>
                                <option value="9">Septiembre</option>
                                <option value="10">Octubre</option>
                                <option value="11">Noviembre</option>
                                <option value="12">Diciembre</option>
                            </select>
                            <label for="mes">Mes de Vacaciones</label>
                        </div>
                        <div class="input-field col m12 l6 s12">
                            <i class="material-icons prefix">home_work</i>
                            <input onkeyup="javascript:this.value=this.value.toUpperCase();"  name="funcion" id="funcion" type="text" required="" aria-required="true">
                            <label for="funcion">Funcion/Area</label>
                        </div>
                        <div class="input-field col m12 l6 s12">
                            <i class="material-icons prefix">home</i>
                            <input onkeyup="javascript:this.value=this.value.toUpperCase();" name="direccion" id="direccion" type="text" >
                            <label for="direccion">Dirección</label>
                        </div>
                        <div class="input-field col m12 s12">
                            <span id="error_message" class="red-text text-darken-2"></span>
                            <button type="submit" class="btn cyan waves-effect waves-light right"
                                id="btnsavePersona">Guardar
                                <i class="material-icons right">save</i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="lista" class="col m12 l12 s12">
        <div id="admin" class="col l12 s12 m12">
            <div class="card-panel material-table">
                <div class="table-header">
                    <span class="table-title">Lista de Personal</span>
                    <div class="actions">
                        <a href="#!" class="search-toggle waves-effect btn-flat nopadding"><i
                                class="material-icons">search</i></a>
                    </div>
                </div>
                <table id="datatable" class="mdl-data-table" width="100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Cedula</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Cargo</th>
                            <th>Genero</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="modal1" class="modal modal-fixed-footer">
        <div class="modal-content">
            <nav class="blue">
                <div class="nav-wrapper">
                    <a href="#!" class="brand-logo center">Editar </a>
                </div>
            </nav>
            <div class="row">
                <div class="col l12 s12 m12 ">
                    <div class="card-panel row">
                        <span class="text-darken-2 col s12 l1 m1">Cedula:</span>
                        <span id="pEscCed" class="blue-text text-darken-2 col l2 s12 m2"></span>
                        <span class="text-darken-2 col s12 l1 m1">Nombres:</span>
                        <span id="pEscNom" class="blue-text center-align text-darken-2 col s12 l5 m6"></span>
                        <span class="text-darken-2 col s12 l1 m1">Estado:</span>
                        <a data-activates='dropdown1' style="float: none !important;" class="dropdown-button col s12 l1 m1" href='#!'><span id="pEscEst"
                                class=""></span></a>
                        <ul id='dropdown1' class='dropdown-content'>
                            <li><a onclick="editEstado(1);" href="#!">Activo</a></li>
                            <li><a onclick="editEstado(0);" href="#!">Inactivo</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col s12 l12 m12">
                  <div class="settings-group">
                    <div class="setting">
                      Administrador
                      <div class="switch right">
                        <label> NO  &nbsp;&nbsp;
                          <input id="pAdmin" type="checkbox">
                          <span class="lever"></span>&nbsp;&nbsp; SI
                        </label>&nbsp;&nbsp;&nbsp; 
                         <a onclick="editRol();" id="editAdmin" title="Actualizar"
                                class="btn-small btn-floating red">
                                <i id="updtAdmin" class="large material-icons">mode_edit</i>
                            </a>
                      </div>
                    </div>
                    <ul class="collapsible setting">
                      <li class="">
                        <div class="collapsible-header" tabindex="0">
                          <span>Datos</span>
                          <i class="material-icons caret right">keyboard_arrow_right</i>
                        </div>
                        <div class="collapsible-body" style="padding: 2px 25px;">
                          <form method="post" id="upd_Persona">
                          <div class="row">
                            <a title="Cancelar" class="modal-action modal-close waves-effect waves-green right btn-flat"><i class="material-icons right">close</i></a>
                            <a id="btn_hab" onclick="habilitar();" class="waves-effect waves-light btn right light-blue"><i class="material-icons right">edit</i>Editar</a>
                            <button style="display: none;" id="btnupdPersona" class="btn waves-effect right waves-light" type="submit" name="action">Enviar<i class="material-icons right">send</i></button>
                          </div>
                          <div class="row">
                              <div class="input-field col s8">
                                <input disabled="" placeholder="Ej: Manta" onkeyup="javascript:this.value=this.value.toUpperCase();" value=" " id="upd_addre" type="text" class="validate">
                                <label for="upd_addre" class="active">Direccion</label>
                              </div>
                              <div class="input-field col s4">
                                <input disabled="" placeholder="Ej: 0987654321" id="upd_telef" type="text" maxlength="10" class="validate">
                                <label for="upd_telef" class="active">Telefono</label>
                              </div>
                              <div class="input-field col s5">
                                <input disabled="" placeholder="Ej: example@algo.com" id="upd_email" type="email" required="" aria-required="true" class="validate">
                                <label for="upd_email" class="active">Correo</label>
                              </div>
                              <div class="input-field col s5">
                                <input disabled="" onkeyup="javascript:this.value=this.value.toUpperCase();" value=" " id="upd_funci" type="text" class="validate">
                                <label for="upd_funci" class="active">Funcion</label>
                              </div>
                              <div class="input-field col s2">
                                <select disabled name="cargo1" required id="cargo1"></select>
                                 <label for="cargo1">Cargo</label>
                              </div>
                          </div>
                        </form>
                        </div>
                      </li>
                    </ul>
                    
                  </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Listo</a>
        </div>
    </div>

    <div id="modal5" class="modal ">
        <div class="container">
            <div class="section center-align">
                <span style="font-size:20px; font-weight: 100; font-family: sans-serif;"
                    class="black-text text-darken-4 header">Enviar notificacion a: </span>
                <span id="pUserNot" style="font-size:20px; font-weight: 100; font-family: sans-serif;"
                    class="black-text text-darken-4 header"></span>
                    <br /><br />
                <div class="row">
                    <form id="modalComentario">
                        <div class="col s12 m12 l12"> 
                            <div class=" col s6 m6 l6">
                                <textarea onkeyup="javascript:this.value=this.value.toUpperCase();" required="" id="textarea1" class="materialize-textarea" data-length="120"></textarea>
                                <label for="textarea1">Asunto</label>
                            </div>
                            <div class="col m6 l6 s6">
                                <select style="font-size:10px;" id="tipo" required>
                                    <option value="" selected disabled>Tipo</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col s12 m12 l12"> 
                            <div class="col m4 l4 s4">
                                <input onkeyup="javascript:this.value=this.value.toUpperCase();" name="fecha1" id="fecha1" type="date" required="" aria-required="true">
                                <label for="fecha1">Fecha</label>
                            </div>
                            <div class="col m2 l2 s2">
                                <input onkeyup="javascript:this.value=this.value.toUpperCase();" name="hora1" id="hora1" type="time" required="" aria-required="true">
                                <label for="hora1">Hora</label>
                            </div>
                            <div class="col l6 m6 s6">
                                <input onkeyup="javascript:this.value=this.value.toUpperCase();" name="lugar" id="lugar" type="text" required="" aria-required="true">
                                <label for="lugar">Lugar</label>
                            </div>
                        </div>                       
                       
                        <div class="input-field offset-s3 col s6">
                            <a class="modal-action modal-close waves-effect waves-green btn-flat">Cancelar</a>
                            <button id="envNotif" class="btn waves-effect waves-light" type="submit" name="action">Enviar
                                <i class="material-icons right">send</i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

  <div id="modalInfo" class="modal bottom-sheet">
    <div class="modal-content">
      <a title="Cerrar" href="#!" class="modal-action modal-close secondary-content"><i class="material-icons small red-text">cancel</i></a>
        <h4> Información</h4>
        <div class="row">
          <div class="col s12 m12 l6">
            <ul class="collection">
              <li class="collection-item avatar">
                <i class="material-icons circle blue">account_circle</i>
                <span class="collection-header">Datos Personales</span><br>    
                <span><b>Nombres: </b></span>&nbsp;<span id="infoNom"></span>&nbsp;&nbsp;&nbsp;&nbsp;
                <span><b>Apellidos: </b></span>&nbsp;<span id="infoApe"></span>
                <br>
                <span><b>Cargo:</b></span>&nbsp;<span id="infoCar"></span>&nbsp;&nbsp;&nbsp;&nbsp;
                <span><b>Rol:</b></span>&nbsp;<span id="infoRol"></span>&nbsp;&nbsp;&nbsp;&nbsp;
                <span><b>Estado:</b></span>&nbsp;<span id="infoEstado"></span>
                <br>
                <span><b>Funcion/Area: </b></span>&nbsp;<span id="infoFun"></span>
                <div class="secondary-content">
                  <p>Opciones</p>
                  <a title='Reiniciar Contraseña' id="userPassR" href='#!'><i class='material-icons  blue-grey-text'>lock</i></a> 
                  <a title='Enviar Notificacion' id="userNotif" href='#!'><i class='material-icons  teal-text'>notifications_active</i></a>  
                </div>
              </li>
              <li class="collection-item avatar ">
                <i class="material-icons circle deep-purple">assignment_ind</i>
                <span><b>Cedula: </b></span>&nbsp;<span id="infoCed"></span>&nbsp;&nbsp;&nbsp;&nbsp;
                <span><b>Genero: </b></span>&nbsp;<span id="infoGen"></span>&nbsp;&nbsp;&nbsp;&nbsp;                
                <br>
                <span><b>Dirección: </b></span>&nbsp;<span id="infoDir"></span>&nbsp;&nbsp;&nbsp;&nbsp;
                <span><b>Telefono: </b></span>&nbsp;<span id="infoTel"></span>
                <br>
                <span><b>Correo: </b></span>&nbsp;<span id="infoCor"></span>
              </li>
              <li class="collection-item avatar">               
                <i class="material-icons circle green">date_range</i>    
                <span class="collection-header">Vacaciones</span><br>  
                <span><b>Mes de Vacaciones: </b></span>&nbsp;<span id="infoMva"></span>&nbsp;&nbsp;&nbsp;&nbsp;
                <span><b>Dias: </b></span>&nbsp;<span id="infoDia"></span>
              </li>
            </ul>   
          </div>   
          <div class="col s12 m12 l6">
            <ul class="collection settings-group">
               <li class="collection-item avatar">
                <i class="material-icons circle blue-grey">toc</i>
                <span class="collection-header">Permisos/Licencias</span><br>    
                <p class="collections-content"> Historial Personal</p>
              </li>
                <ul id="permCollap" class="collapsible setting">
                  
                </ul>
            </ul>   
          </div>  
        </div>
    </div>
  </div>
</div>