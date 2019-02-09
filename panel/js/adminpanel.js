function page_graficos(encabezado = true) {
    if (encabezado == true) {
        $.ajax({
            url: "pages/encabezado_graficos.php",
            cache: false,
            success: function(datos) {
                $(".content-wrapper").html(datos);
            }
        });

    } else {
        var inicio = $("#inicio").val();
        var fin = $("#fin").val();
        var suc = $("#suc").val();

        $("#btn-generar").find("span").removeClass('glyphicon glyphicon-tasks');
        $("#btn-generar").find("span").addClass('fa fa-spinner fa-spin');

        $.ajax({
            url: "pages/graficos.php",
            cache: false,
            type: "POST",
            data: "inicio=" + inicio + "&fin=" + fin + "&suc=" + suc,
            success: function(datos) {
                // alert(datos);
                $("#content").html(datos);

                $("#btn-generar").find("span").removeClass('fa fa-spinner fa-spin');
                $("#btn-generar").find("span").addClass('glyphicon glyphicon-tasks');
            }
        });

    }
}

function page_reporte(encabezado = true) {
    if (encabezado == true) {

        $.ajax({
            url: "pages/encabezado_reporte.php",
            cache: false,
            success: function(datos) {
                $(".content-wrapper").html(datos);
            }
        });

    } else {
        var inicio = $("#inicio").val();
        var fin = $("#fin").val();
        var suc = $("#suc").val();

        $("#btn-generar").find("span").removeClass('glyphicon glyphicon-tasks');
        $("#btn-generar").find("span").addClass('fa fa-spinner fa-spin');

        $.ajax({
            url: "pages/reporte_general.php",
            cache: false,
            type: "POST",
            data: "inicio=" + inicio + "&fin=" + fin + "&suc=" + suc,
            success: function(datos) {
                $("#content").html(datos);

                $("#btn-generar").find("span").removeClass('fa fa-spinner fa-spin');
                $("#btn-generar").find("span").addClass('glyphicon glyphicon-tasks');
                // componentHandler.upgradeDom();
            }
        });
    }
}


function lista_claves(encabezado = true) {
    if (encabezado == true) {
        $.ajax({
            url: "pages/encabezado_claves.php",
            cache: false,
            success: function(datos) {
                $(".content-wrapper").html(datos);
            }
        });

    } else {
        var cve_encuesta = $("#cve_encuesta").val();
        var suc = $("#suc").val();
        // alert(suc);
        $("#btn-generar").find("span").removeClass('glyphicon glyphicon-tasks');
        $("#btn-generar").find("span").addClass('fa fa-spinner fa-spin');

        if (cve_encuesta != "-") {
            $.ajax({
                url: "pages/lista_claves.php",
                cache: false,
                type: "POST",
                data: "cve_encuesta=" + cve_encuesta + "&suc=" + suc,
                success: function(datos) {
                    $("#content").html(datos);

                    $("#btn-generar").find("span").removeClass('fa fa-spinner fa-spin');
                    $("#btn-generar").find("span").addClass('glyphicon glyphicon-tasks');
                    // componentHandler.upgradeDom();
                }
            });

        } else {
            $("#btn-generar").find("span").removeClass('fa fa-spinner fa-spin');
            $("#btn-generar").find("span").addClass('glyphicon glyphicon-tasks');
            alert("Encuesta Invalida");
        }

    }
}

function descargarExcel() {
    //Creamos un Elemento Temporal en forma de enlace
    var tmpElemento = document.createElement('a');
    // obtenemos la información desde el div que lo contiene en el html
    // Obtenemos la información de la tabla
    var data_type = 'data:application/vnd.ms-excel';
    var tabla_div = document.getElementById('tabla_general');
    var tabla_html = tabla_div.outerHTML.replace(/ /g, '%20');
    tmpElemento.href = data_type + ', ' + tabla_html;
    //Asignamos el nombre a nuestro EXCEL
    tmpElemento.download = 'Reporte.xls';
    // Simulamos el click al elemento creado para descargarlo
    tmpElemento.click();
}


function btn_detalle(grafico) {
    var inicio = $("#inicio").val();
    var fin = $("#fin").val();

    switch (grafico) {
        case 1:
            $("#detalle_grafico .modal-title").html("<b>Quejas por Sucursal</b>");
            break;

        case 2:
            $("#detalle_grafico .modal-title").html("<b>Quejas por Perjuicio</b>");
            break;

        case 3:
            $("#detalle_grafico .modal-title").html("<b>Quejas por Puesto</b>");
            break;

    }

    $.ajax({
        url: "pages/modal_detalle.php",
        type: "POST",
        cache: false,
        data: "grafico=" + grafico + "&inicio=" + inicio + "&fin=" + fin,
        success: function(datos) {
            $("#detalle_grafico .modal-body").html(datos);
            $("#detalle_grafico").modal("show");
            componentHandler.upgradeDom();
        }
    });

}


// ==========================================
// Para el Uso de Cookie de Session
// ==========================================
function verificarcookie(ubicacion) {
    var cookieusuario = Cookies.get('usuario');

    if (cookieusuario == undefined) {
        if (ubicacion != 'login.php') {
            location.href = "login.php";
        }
    } else {
        if (ubicacion == "login.php") {
            location.href = "http://acerosocotlan.mx/gao/encuestaldn/panel/";
           // location.href = "http://localhost/acerosocotlan/encuesta_iso9000/panel/";
        }
    }
}

function crearcookie(usuario, nombre, area, correo) {
    Cookies.set("usuario", usuario);
    Cookies.set("nombre", nombre);
    Cookies.set("area", area);
    Cookies.set("correo", correo);
}

function eliminarcookie(ubicacion) {
    Cookies.remove("usuario");
    Cookies.remove("nombre");
    Cookies.remove("area");
    Cookies.remove("correo");

    verificarcookie(ubicacion);

}

function iniciarsession() {
    var usuario = $("#usuario").val();
    var clave = $("#clave").val();

    if (usuario != "") {
        if (clave != "") {
            $("#btn_acceder").html("<i class='fa fa-spinner fa-spin'></i>");
            $.ajax({
                url: "script/validaingreso.php",
                type: "POST",
                cache: false,
                data: "usuario=" + usuario + "&clave=" + clave,
                success: function(datos) {
                    var info = datos.split("|");
                    // [0]=> Status | [1]=> Usuario | [2]=> Nombre | [3]=> Correo | [4]=> Area
                    $("#btn_acceder").html("Acceder");
                    if (info[0] == "encontrado") {

                        crearcookie(info[1], info[2], info[4], info[3]); // Crea las cookies
                        location.href = "http://acerosocotlan.mx/gao/encuestaldn/panel/";
                        // location.href = "http://localhost/acerosocotlan/encuesta_iso9000/panel/";

                    } else {
                        alert(info[0]);
                    }

                }
            });
        } else {
            alert("Debe indicar su contraseña");
        }
    } else {
        alert("Indique su Usuario");
    }

}

// ==========================================