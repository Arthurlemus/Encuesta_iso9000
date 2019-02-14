var siguientepregunta = 0;
// ──────────────────────────────────────────────────────────────────────────────── I ──────────
//   :::::: V A R I A B L E S  1 R A   S C R E E N : :  :   :    :     :        :          :
// ──────────────────────────────────────────────────────────────────────────────────────────
var company = "";
var who = "";
var email = "";
var telephone = "";

var P1 = "";
var P2 = "";
var P3 = "";
var P4 = "";
var P5 = "";
var P6 = "";
var P7 = "";
var P8 = "";
var P9 = "";
var P10 = "";
var P11 = "";
// ─────────────────────────────────────────────────────────────────────────────

$(document).on("ready", function() {
    $("#formulario").on('submit', function(evt) {
        evt.preventDefault();
        // tu codigo aqui
    });


})

// ──────────────────────────────────────────────────────────────────────────────────────────── I ──────────
//   :::::: P A S A R   D I R E C T A M E N T E   A L   M A I N : :  :   :    :     :        :          :
// ──────────────────────────────────────────────────────────────────────────────────────────────────────
function brincarclave() {
    $.ajax({
        url: "pages/main.php",
        cache: false,
        success: function(datos) {
            $("#main-content").html(datos);
        }
    });
}
// ─────────────────────────────────────────────────────────────────────────────

function iniciar_session(opcion = 0) // [0] Sin Session [1] Con session
{
    if (opcion == 0) {
        var pin = $("#clave").val();

    } else {
        var pin = opcion;
    }

    if (pin != "") {
        $.ajax({
            url: "script/validaingreso.php",
            cache: false,
            type: "POST",
            data: "pin=" + pin,
            success: function(datos) {
                var info = datos.split("|");
                if (info[0].trim() == "encontrado") {
                    $.ajax({
                        url: "pages/main.php",
                        cache: false,
                        success: function(datos) {
                            $("#main-content").html(datos);
                            // componentHandler.upgradeDom();
                        }
                    });
                } else {

                    if (info[0].trim() != "backhome") {
                        alert(info[0]);
                    }
                }
            }
        });

    } else {
        alert("Introduzca su Clave");
    }

}

// ──────────────────────────────────────────────────────────────────────────────────────────────────────────────────────── I ──────────
//   :::::: I N I C I A   D E S P U E S   D E   P O N E R   E M P R E S A   Y   C O R R E O : :  :   :    :     :        :          :
// ──────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────
function iniciar_encuesta() {

    siguientepregunta = 0;
    $("#mini_loading").show();

    company = $("#company").val();
    email = $("#email").val();
    telephone = $("#telephone").val();
    who = $("#who").val();

    if (company != "" && email != "" && who != "") {
        $.ajax({
            url: "pages/preguntas.php",
            cache: false,
            type: "POST",
            data: "siguientepregunta=" + siguientepregunta,
            success: function(datos) {
                $("#principal").html(datos);
                $("#mini_loading").hide();
                // componentHandler.upgradeDom();
            }
        });

    } else {
        alert("Por favor llene los campos obligatorios");
        $("#mini_loading").hide();

    }
}
// ─────────────────────────────────────────────────────────────────────────────

function instrucciones() {
    $.ajax({
        url: "pages/instrucciones.php",
        cache: false,
        success: function(datos) {
            $("#principal").html(datos);
            $("#mini_loading").hide();
        }
    });
}




function pregunta_siguiente() {

    // ===================================
    // Valida el tipo de Input
    // ===================================

    var tipoinput = $("#respuesta").attr("type");
    if (tipoinput == "text") {
        var respuesta = $("input:text[name=respuesta]").val();

    } else {

        var respuesta = $("input:radio[name=respuesta]:checked").val();
    }
    // ===================================

    // var codigopregunta = $("#codigopregunta").val();
    var codigoencuesta = $("#codigoencuesta").val();
    var pinencuesta = $("#pinencuesta").val();
    var sucursal = $("#sucursal").val();
    var factura = $("#factura").val();
    var origen = "Web";

    var extra = $("#extra").val(); // PAra las preguntas adicionales
    var why = "-";
    var example = "-";


    if (extra == 1) // Si contine preguntas adicionales
    {
        why = $("#why").val().trim();
        example = $("#example").val().trim();
    }
     
    if(siguientepregunta==10){ // Para hacer opcional solo la pregunta 11
        if(respuesta==""){
            respuesta="-";
        }
    }

    if (respuesta != "" && respuesta != undefined && why != "" && example != "") {

        $("input:radio[name=respuesta]").attr("disabled", true);

        $("#mini_loading").show();

        siguientepregunta = siguientepregunta + 1;
        switch (siguientepregunta) {
            case 1:
                P1 = respuesta;
                break;
            case 2:
                P2 = respuesta;
                break;
            case 3:
                P3 = respuesta;
                break;
            case 4:
                P4 = respuesta;
                break;
            case 5:
                P5 = respuesta;
                break;
            case 6:
                P6 = respuesta;
                break;
            case 7:
                P7 = respuesta;
                break;
            case 8:
                P8 = respuesta;
                break;
            case 9:
                P9 = respuesta;
                break;
            case 10:
                P10 = respuesta;
                break;
            case 11:
                P11 = respuesta;
                // alert(P1);
                $.ajax({
                    url: "script/guardarencuesta.php",
                    cache: false,
                    type: "POST",
                    data: "P1=" + P1 + "&P2=" + P2 + "&P3=" + P3 + "&P4=" + P4 + "&P5=" + P5 + "&P6=" + P6 + "&P7=" + P7 +
                        "&P8=" + P8 + "&P9=" + P9 + "&P10=" + P10 + "&P11=" + P11 + "&pin=" + pinencuesta + "&sucursal=" + sucursal + "&factura=" + factura + "&origen=" + origen +
                        "&codigoencuesta=" + codigoencuesta + "&extra=" + extra + "&why=" + why + "&example=" + example + "&company=" + company + "&who=" + who + "&email=" + email + "&telephone=" + telephone,
                    success: function(datos) {
                        // 
                    }
                });
                break;
            default:
                break;
        }

        $.ajax({
            url: "pages/preguntas.php",
            cache: false,
            type: "POST",
            data: "siguientepregunta=" + siguientepregunta,
            success: function(datos) {
                $("#principal").html(datos);
                $("#mini_loading").hide();
                // componentHandler.upgradeDom();
            }
        });

    } //IF FINAL
    else {
        alert("Respuesta Incompleta");
    }

}

function encuesta_finalizada() {
    siguientepregunta = 0;
    location.reload();
    // $.ajax({
    //   url:"pages/main.php",
    //   cache:false,
    //   success:function(datos){
    //     $("#main-content").html(datos);
    //             // componentHandler.upgradeDom();
    //           }
    //         });

}