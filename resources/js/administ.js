var dCargos = [];
var dNotifi = [];
var not = [];
var c = [];

$(document).ready(function () {
    $('ul.tabs').tabs();
    $('#modalCargo').modal();
    $('#modalNotifi').modal();

    $('.tabs').click(function () {
        $.fn.dataTable.tables({ visible: true, api: true })
            .columns.adjust().draw();
    });
    $('.search-toggle').click(function () {
        if ($('.hiddensearch').css('display') == 'none')
            $('.hiddensearch').slideDown();
        else
            $('.hiddensearch').slideUp();
    });

    $("#nuevoCargo").click(function () {
        document.getElementById('titCargo').innerHTML = 'Nuevo Cargo';
        var form = document.getElementById('formCargo'); form.reset();
        form.querySelector('#descri').innerHTML = ''
        $("#btn_aggCargo").show(); $("#btn_ediCargo").hide();
    });

    $("#nuevaNotifi").click(function () {
        document.getElementById('titNotifi').innerHTML = 'Nuevo Tipo de Notificación';
        var form = document.getElementById('formNotif'); form.reset();
        $("#btn_aggnotif").show(); $("#btn_ediNotif").hide();
    });

    $("#formNotif").on("submit", function (e) {
        e.preventDefault();
        var table = $('#table_notif').DataTable();
        var form = document.getElementById('formNotif');
        var name = form.querySelector('#nNotif').value.trim()
        $.ajax({
            url: 'class/Admin.php',
            method: 'POST',
            data: { name, action: 'aggNotif' },
            success: function (data) {
                var data = JSON.parse(data);
                if (data.status == "400") {
                    Materialize.toast('Notificación agregada', 4000, 'green accent-4');
                } else if (data.status == "200") {
                    Materialize.toast('Error: ' + data.msg, 4000, 'red lighten-2');
                }
            },
            error: function (data) {
                Materialize.toast(data, 2000);
            },
            complete: function () {
                $('#modalNotifi').modal('close');
                table.ajax.reload();
                form.reset();
            },
        });
    });

    $("#formCargo").on("submit", function (e) {
        e.preventDefault();
        var table_cargo = $('#table_cargo').DataTable();
        var form = document.getElementById('formCargo');
        var descr = form.querySelector('#descri').value.trim()
        var name = form.querySelector('#nCargo').value.trim()
        var compnam = name.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, "")
        c = dCargos.find(x => x.Nombre.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, "") === compnam);

        if (c) {
            Materialize.toast('Error: El cargo ' + name + ' ya existe', 4000, 'red lighten-2');
        } else {
            $.ajax({
                url: 'class/Admin.php',
                method: 'POST',
                data: { name, descr, action: 'aggCargo' },
                success: function (data) {
                    var data = JSON.parse(data);
                    if (data.status == "400") {
                        Materialize.toast('Cargo agregado', 4000, 'green accent-4');
                    } else if (data.status == "200") {
                        Materialize.toast('Error: ' + data.msg, 4000, 'red lighten-2');
                    }
                },
                error: function (data) {
                    Materialize.toast(data, 2000);
                },
                complete: function () {
                    $('#modalCargo').modal('close');
                    table_cargo.ajax.reload();
                    form.reset();
                },
            });
        }
    });

    $("#btn_ediCargo").on("click", function (e) {
        e.preventDefault();
        var id = c.Id_cargo
        var form = document.getElementById('formCargo');
        var descr = form.querySelector('#descri').value.trim()
        var name = form.querySelector('#nCargo').value.trim()
        var table_cargo = $('#table_cargo').DataTable();
        if (name === '') {
            Materialize.toast('El campo nombre no puede estar vacio', 4000);
        } else {
            var r = confirm("Actualizar Cargo?");
            if (r == true) {
                $.ajax({
                    url: 'class/Admin.php',
                    method: 'POST',
                    data: { id, name, descr, action: 'ediCargo' },
                    success: function (data) {
                        var data = JSON.parse(data);
                        if (data.status == "400") {
                            Materialize.toast('Cargo actualizado', 4000, 'green accent-4');
                        } else if (data.status == "200") {
                            Materialize.toast('Error: ' + data.msg, 4000, 'red lighten-2');
                        }
                    },
                    error: function (data) {
                        Materialize.toast(data, 2000);
                    },
                    complete: function () {
                        $('#modalCargo').modal('close');
                        table_cargo.ajax.reload();
                        form.reset();
                    },
                });
            }
        }
    });

    $("#btn_ediNotif").click(function () {
        var form = document.getElementById('formNotif');
        var name = form.querySelector('#nNotif').value.trim()
        var table = $('#table_notif').DataTable();
        var id = not.Id_TipoNotific;
        if (name == '') {
            Materialize.toast('El campo nombre no puede estar vacio', 4000);
        } else {
            var r = confirm("Actualizar Notificación?");
            if (r == true) {
                $.ajax({
                    url: 'class/Admin.php',
                    method: 'POST',
                    data: { id, name, action: 'ediNotif' },
                    success: function (data) {
                        var data = JSON.parse(data);
                        if (data.status == "400") {
                            Materialize.toast('Notifación actualizado', 4000, 'green accent-4');
                        } else if (data.status == "200") {
                            Materialize.toast('Error: ' + data.msg, 4000, 'red lighten-2');
                        }
                    },
                    error: function (data) {
                        Materialize.toast(data, 2000);
                    },
                    complete: function () {
                        $('#modalNotifi').modal('close');
                        table.ajax.reload();
                        form.reset();
                    },
                });
            }
        }
    });

    $('#table_cargo').dataTable({
        dom: "<'hiddensearch'f'>" + "tr" + "<'table-footer'Blip'>",
        renderer: 'material',
        responsive: true,
        sWrapper: "dataTables_wrapper",
        sFilterInput: "form-control input-sm",
        sLengthSelect: "form-control input-sm",
        "ajax": {
            url: 'class/Admin.php',
            method: 'POST',
            data: { action: 'CargoDet' },
            "dataSrc": function (json) {
                for (var i = 0, ien = json.length; i < ien; i++) {
                    dCargos[i] = json[i];
                    json[i] = [i + 1, json[i]['Nombre'], json[i]['Descripcion'].substring(0, 50) + "...", json[i]['CantPers'],
                    "<a title='Editar' onclick='editCargo(" + json[i]['Id_cargo'] + ")' href='#!'><i class='material-icons'>edit</i></a>"
                    + "<a title='Eliminar' onclick='deletCargo(" + json[i]['Id_cargo'] + ")' href='#!'><i class='material-icons  red-text'>delete</i></a>"
                    ]
                }
                return json;
            }
        },
        buttons: [
            { text: '<span style="color:#4d4d4d;">Recargar<span>', action: function (e, dt, node, config) { dt.ajax.reload(); } }
        ],
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "_START_ - _END_ de _TOTAL_ ",
            "sInfoEmpty": "No hay registros ",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "",
            "searchPlaceholder": "Busqueda",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": '<i class="material-icons">first_page</i>',
                "sLast": '<i class="material-icons">last_page</i>',
                "sNext": '<i class="material-icons">navigate_next</i>',
                "sPrevious": '<i class="material-icons">navigate_before</i>',
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
            "sLengthMenu": '<span>Ver: </span><select class="browser-default">' +
                '<option value="10">10</option>' + '<option value="20">20</option>' + '<option value="30">30</option>' +
                '<option value="40">40</option>' + '<option value="50">50</option>' + '<option value="-1">Todo</option>' +
                '</select></div>'
        },
        "bAutoWidth": false,
        "bDeferRender": true,
        "pagingType": "full",
        "scrollY": "360px",
        "scrollCollapse": true,
    });

    $('#table_notif').dataTable({
        dom: "<'hiddensearch'f'>" + "tr" + "<'table-footer'Blip'>",
        renderer: 'material',
        responsive: true,
        sWrapper: "dataTables_wrapper",
        sFilterInput: "form-control input-sm",
        sLengthSelect: "form-control input-sm",
        "ajax": {
            url: 'class/Admin.php',
            method: 'POST',
            data: { action: 'NotifDet' },
            "dataSrc": function (json) {
                for (var i = 0, ien = json.length; i < ien; i++) {
                    dNotifi[i] = json[i];
                    json[i] = [i + 1, json[i]['Nombre'],
                    "<a title='Editar' onclick='editNotif(" + json[i]['Id_TipoNotific'] + ")' href='#!'><i class='material-icons'>edit</i></a>"
                    + "<a title='Eliminar' onclick='deletNotif(" + json[i]['Id_TipoNotific'] + ")' href='#!'><i class='material-icons  red-text'>delete</i></a>"
                    ]
                }
                return json;
            }
        },
        buttons: [
            { text: '<span style="color:#4d4d4d;">Recargar<span>', action: function (e, dt, node, config) { dt.ajax.reload(); } }
        ],
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "_START_ - _END_ de _TOTAL_ ",
            "sInfoEmpty": "No hay registros ",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "",
            "searchPlaceholder": "Busqueda",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": '<i class="material-icons">first_page</i>',
                "sLast": '<i class="material-icons">last_page</i>',
                "sNext": '<i class="material-icons">navigate_next</i>',
                "sPrevious": '<i class="material-icons">navigate_before</i>',
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
            "sLengthMenu": '<span>Ver: </span><select class="browser-default">' +
                '<option value="10">10</option>' + '<option value="20">20</option>' + '<option value="30">30</option>' +
                '<option value="40">40</option>' + '<option value="50">50</option>' + '<option value="-1">Todo</option>' +
                '</select></div>'
        },
        "bAutoWidth": false,
        "bDeferRender": true,
        "pagingType": "full",
        "scrollY": "360px",
        "scrollCollapse": true,
    });

});

function editNotif(id) {
    not = dNotifi.find(x => x.Id_TipoNotific == id)
    var form = document.getElementById('formNotif');
    document.getElementById('titNotifi').innerHTML = 'Editar Notificación'
    form.querySelector('#nNotif').value = not.Nombre
    $("#btn_aggnotif").hide(); $("#btn_ediNotif").show();
    $('#modalNotifi').modal('open');
}

function deletNotif(id) {
    not = dNotifi.find(x => x.Id_TipoNotific == id)

    var table = $('#table_notif').DataTable();

    var r = confirm("Elliminar Notificación?");
    if (r == true) {
        $.ajax({
            url: 'class/Admin.php',
            method: 'POST',
            data: { id, action: 'delNotif' },
            success: function (data) {
                var data = JSON.parse(data);
                if (data.status == "400") {
                    Materialize.toast('Notifación eliminada', 4000, 'green accent-4');
                } else if (data.status == "200") {
                    Materialize.toast('Error: ' + data.msg, 4000, 'red lighten-2');
                }
            },
            error: function (data) {
                Materialize.toast(data, 2000);
            },
            complete: function () {
                table.ajax.reload();
            },
        });
    }
}


function editCargo(id) {
    c = dCargos.find(x => x.Id_cargo == id);
    var form = document.getElementById('formCargo'); form.reset();
    document.getElementById('titCargo').innerHTML = 'Editar Cargo'
    form.querySelector('#descri').innerHTML = c.Descripcion
    form.querySelector('#nCargo').value = c.Nombre
    $("#btn_aggCargo").hide(); $("#btn_ediCargo").show();
    $('#modalCargo').modal('open');   
}

function deletCargo(id) {
    c = dCargos.find(x => x.Id_cargo == id);
    var table_cargo = $('#table_cargo').DataTable();
    if (c.CantPers > 0) {
        Materialize.toast('No es posible eliminar el Cargo \n Hay Usuarios que dependen de este', 4000);
    } else {
        var r = confirm("Eliminar Cargo?");
        if (r == true) {
            $.ajax({
                url: 'class/Admin.php',
                method: 'POST',
                data: { id, action: 'delCargo' },
                success: function (data) {
                    var data = JSON.parse(data);
                    if (data.status == "400") {
                        Materialize.toast('Cargo eliminado', 4000, 'green accent-4');
                    } else if (data.status == "200") {
                        Materialize.toast('Error: ' + data.msg, 4000, 'red lighten-2');
                    }
                },
                error: function (data) {
                    Materialize.toast(data, 2000);
                },
                complete: function () {
                    table_cargo.ajax.reload();
                },
            });
        }
    }
}