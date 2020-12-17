//Cuando se carga el documento se ejecuta esto para impedir que se vean las ventanas modales de primeras sin haberlas llamado
$(document).ready(function(){
    $("#formularioAlta").css("visibility","hidden");
    $("#formularioModi").css("visibility","hidden");
    cerrarModalPDF();
    cerrarModalRespuesta();
    
});


//Termina la sesion actual
$(document).ready(function() {
    $("#endSession").click(function() {
        location.href="./../destroySession.php";
    });
});

//Funcion para borrar el table Body
$(document).ready(function() {
    $("#delete").click(function(){
        $("#tbDatos").empty();
    })
});

//Funcion para borrar una fila de la tabla identificandola a traves de su id de turno
function borrar(argIdTurno){
    if(confirm("Esta seguro?")){
        var objAjax = $.ajax({
            type:"get",
            url:"./delete.php",
            data:{
                IdTurno : argIdTurno
            },
            success: function(respuesta, estado){
                cargaTabla();
                $("#textoResp").html(respuesta);
                $("#modalRespuesta").css("visibility","visible");
                
            }
        })
    }else{
        alert("Ha sido cancelado.");
    }
}

function ejecutarBorrar(){
    var i = this.document.activeElement.getAttribute("class");
    borrar(i);
}

//Validez del formulario de modificacion
function todoListoParaModi(){
    if (($("#modiID").isValid()==true) &&
    ($("#modiApellidoDr").checkValidity()==true) &&
    ($("#modiMatriculaDr").checkValidity()==true) &&
    ($("#modiEspecialidad").checkValidity()==true) &&
    ($("#modiApellidoPaciente").checkValidity()==true) &&
    ($("#modiFechaTurno").checkValidity()==true) ){
        
        $("#modiValidar").attr("disabled",false);
    }else{
        $("#modiValidar").attr("disabled",true);
        
    }
};


//Validez del formulario de Alta
function todoListoParaAlta(){
    if (($("#altaID").isValid()==true) &&
    ($("#altaApellidoDr").isValid()==true) &&
    ($("#altaMatriculaDr").isValid()==true) &&
    ($("#altaEspecialidad").isValid()==true) &&
    ($("#altaApellidoPaciente").isValid()==true) &&
    ($("#altaFechaTurno").isValid()==true) ){
        
        $("#altaValidar").attr("disabled",false);
    }else{
        $("#altaValidar").attr("disabled",true);
    }
};

//Funcion para dar de alta un registro nuevo en la base de datos de turnos
function Alta(){
    if(confirm("Esta Seguro?")){
        var formData = new FormData(document.getElementById("formAlta"));
        $objAjax = $.ajax({
            type:"post",
            url:"./alta.php",
            data:formData,
            processData: false,
            contentType: false,
            success: function(respuesta, estado){
                cargaTabla();
                cerrarModalAlta();
                $("#textoResp").html(respuesta);
                $("#modalRespuesta").css("visibility","visible");
                $("#cancelRes").click(function(){
                    $("#modalRespuesta").css("visibility","hidden");
                });              
            }
        })
    }else{
        alert("Se ha cancelado la operacion");
    }
};


//Funcion para actualizar algun dato de una fila de la tabla
function update(argIdTurno){
    if (confirm("Estas seguro?")){
        var formData = new FormData(document.getElementById("formModi"));
        $objAjax = $.ajax({
            type:"post",
            url:"./modi.php",
            data:formData,
            processData: false,
            contentType: false,
            success: function(respuesta, estado){
                cargaTabla();
                cerrarModalModi();
                $("#textoResp").html(respuesta);
                $("#modalRespuesta").css("visibility","visible");
            }
        })
    }else{
        alert("Ha cancelado la operacion");
    }
};

function ejecutarUpdate(){
    console.log(savedValue);
    update(savedValue);
};




//Funcion para abrir la ventana modal con el boton 'Alta Registro'
function abrirModalAlta(){
    cargaSelectAlta();
    $("#formularioAlta").css("visibility","visible");
    $("#doc").addClass("contenedorDesactivado");
};

//Funcion para cerrar la ventana modal de Alta con el boton 'X'
function cerrarModalAlta(){
    $("#formularioAlta").css("visibility","hidden");
    $("#doc").removeClass("contenedorDesactivado");
};

//Funcion para cerrar la ventana modal de Alta con el boton 'X'
function cerrarModalModi(){
    $("#formularioModi").css("visibility","hidden");
    $("#doc").removeClass("contenedorDesactivado");
};


var savedValue;
//Funcion para abrir la ventana modal de modificacion
function abrirModalModi(){
    $("#formularioModi").css("visibility","visible");
    //IMPORTANTISIMO
    var i = this.document.activeElement.getAttribute("class");
    savedValue = i;
    completarFichaModi(i);
    $("#doc").addClass("contenedorDesactivado");
};

//Funcion para autocompletar 
function completarFichaModi(argIdTurno){
    $("#formularioModi").val(argIdTurno);
    var objAjax = $.ajax({
        type:"get",
        url:"./autoFormModi.php",
        data:{IdTurno:argIdTurno},
        success:function(respuestaDelServer,estado){
            console.log(respuestaDelServer);
            objetoDato = JSON.parse(respuestaDelServer);
            
            $("#modiID").val(objetoDato.IdTurno);
            $("#modiApellidoDr").val(objetoDato.ApellidoDr);
            $("#modiMatriculaDr").val(objetoDato.Matricula);
            $("#modiEspecialidad").val(objetoDato.Especialidad);
            $("#modiApellidoPaciente").val(objetoDato.ApellidoPaciente);
            $("#modiFechaTurno").val(objetoDato.FechaTurno);
        }
    });
};


//Esta funcion Se va a encargar de realizar la consulta ajax y traer los datos del servidor.
function cargaTabla(){
    //Vacio la tabla por si la cargo dos veces no se me dupliquen los registros
    $("#tbDatos").empty();
    //añado un elemento temporal para mostrar que se esta esperando la respuesta del servidor
    $("#tbDatos").html("<p>Esperando respuesta....></p>")
    //Comienzo de 
    var objAjax = $.ajax({
        //type: puede ser get o post. En el caso de get se van a buscar datos mientras que con post se van a 'postear'
        type:"get",
        //Indicamos la direccion del archivo php al cual se quiere acceder
        url:"salidaJson.php",
        //Aca especificamos los datos que se le van a pasar a la consulta de php
        data:{
            orden: $("#orden").val(),
            //En esta parte voy a acceder a los valores de los filtros (los inputs) para pasarselos como parametro a la consulta php en el caso
            //que se quiera ordenar de alguna manera en particular
            filtroIdTurno : $("#filtroIdTurno").val(),
            filtroApellidoDr : $("#filtroApellidoDr").val(),
            filtroMatricula : $("#filtroMatricula").val(),
            filtroEspecialidad : $("#filtroEspecialidad").val(),
            filtroApellidoPaciente : $("#filtroApellidoPaciente").val(),
            filtroFechaTurno : $("#filtroFechaTurno").val()
        },
        //Indicaremos que hacer en el caso que la consulta sea aceptada
        success: function(respuestaDelServer,estado){
            //Borramos el tbody para quitar el texto de 'esperando la respuesta'
            $("#tbDatos").empty();
            //console.log(respuestaDelServer);\\
            //Convertiremos la respuesta que nos dio el servidor a un archivo de formato JSON para poder trabajar con mayor facilidad
            objJson = JSON.parse(respuestaDelServer);
            
            //El archivo json que se nos devuelve tendra como nombre 'turnos'
            var objTbDatos = $("#tbDatos");
            //Usamos este metodo foreach para que por cada turno nos extraiga los datos de cada uno de sus campos para posteriormente poder 
            //pasarselos a nuestro tbody en formato de filas
            objJson.turnos.forEach(function(argValor,argIndice){
                
                //Aqui creo el table row donde ira cada nueva fila
                var objTr = document.createElement("tr");
                objTr.setAttribute("class","DB");
                
                //De aca en adelante se crea un objeto td que sera insertado en la fila anteriormente creada
                var objTdId = document.createElement("td");
                objTdId.setAttribute("campo-dato","turnos_IdTurno");
                objTdId.innerHTML= argValor.IdTurno;
                
                var objTdApellidoDr = document.createElement("td");
                objTdApellidoDr.setAttribute("campo-dato","turnos_ApellidoDr");
                objTdApellidoDr.innerHTML= argValor.ApellidoDr;
                
                var objTdMatricula = document.createElement("td");
                objTdMatricula.setAttribute("campo-dato","turnos_Matricula");
                objTdMatricula.innerHTML= argValor.Matricula;
                
                var objTdEspecialidad = document.createElement("td");
                objTdEspecialidad.setAttribute("campo-dato","turnos_Especialidad");
                objTdEspecialidad.innerHTML= argValor.Especialidad;
                
                var objTdApellidoPaciente = document.createElement("td");
                objTdApellidoPaciente.setAttribute("campo-dato","turnos_ApellidoPaciente");
                objTdApellidoPaciente.innerHTML= argValor.ApellidoPaciente;
                
                var objTdFechaTurno = document.createElement("td");
                objTdFechaTurno.setAttribute("campo-dato","turnos_FechaTurno");
                objTdFechaTurno.innerHTML= argValor.FechaTurno;
                
                var objTdPDF = document.createElement("td");
                objTdPDF.setAttribute("campo-dato","pdf");
                objTdPDF.innerHTML = "<button style='cursor: pointer;'>Doc.pdf</button>";
                objTdPDF.onclick=function(){
                    //Creo una ventana modal para los pdfs
                    $("#modalPDF").css("visibility", "visible");
                    $("#contenidoPDF").empty();
                    $("#contenidoPDF").html("<iframe width='100%' height='500px' src='data:application/pdf;base64,"+argValor.Pdf+"'></iframe>");
                }
                
                var objTdMod = document.createElement("td");
                objTdMod.setAttribute("campo-dato","modis");
                objTdMod.innerHTML = "<button style='cursor: pointer;' id='modi' class="+"'"+argValor.IdTurno+"'"+"onclick='abrirModalModi()'>MODI</button>";
                
                var objTdBaja = document.createElement("td");
                objTdBaja.setAttribute("campo-dato","bajas");
                objTdBaja.innerHTML = "<button style='cursor: pointer;' id='baja' class="+"'"+argValor.IdTurno+"'"+"onclick='ejecutarBorrar()'>BORRAR</button>";
                
                
                
                //añado los td's creados al tr
                objTr.append(objTdId,objTdApellidoDr,objTdMatricula,objTdEspecialidad,objTdApellidoPaciente,objTdFechaTurno,objTdPDF, objTdMod, objTdBaja);
                //añado cada tr a un objeto
                objTbDatos.append(objTr);                        
            });
            //añado el objeto con todos los tr's a mi objeto tbody que tiene el id 'tbdatos'
            $("#tbDatos").append(objTbDatos);
            $("#cantRegistros").html("Nro de registros: " + objJson.turnos.length);
        }
        
    });
};

//Funcion para cargar la tabla de acuerdo al Id del turno
$(document).ready(function(){
    $("#thTurnoId").click(function(){
        $("#orden").val("IdTurno");
        cargaTabla();
    });
});

//Funcion para cargar la tabla de acuerdo a la matricula del doctor
$(document).ready(function(){
    $("#thTurnoMat").click(function(){
        $("#orden").val("Matricula");
        cargaTabla();
    });
});

//Funcion para cargar la tabla de acuerdo al apellido del doctor
$(document).ready(function(){
    $("#thTurnoApDr").click(function(){
        $("#orden").val("ApellidoDr");
        cargaTabla();
    });
});

//Funcion para cargar la tabla de acuerdo a la especialidad
$(document).ready(function(){
    $("#thTurnoEspec").click(function(){
        $("#orden").val("Especialidad");
        cargaTabla();
    });
});

//Funcion para cargar la tabla de acuerdo al  Apellido del paciente
$(document).ready(function(){
    $("#thTurnoApPa").click(function(){
        $("#orden").val("ApellidoPaciente");
        cargaTabla();
    });
});

//Funcion para cargar la tabla de acuerdo a la fecha del turno
$(document).ready(function(){
    $("#thTurnoFeTu").click(function(){
        $("#orden").val("FechaTurno");
        cargaTabla();
    });
});

$.fn.isValid = function(){
    return this[0].checkValidity()
}

function cerrarModalPDF(){
    $(document).ready
    $("#modalPDF").css("visibility", "hidden");
};

function cerrarModalRespuesta(){
    $("#modalRespuesta").css("visibility", "hidden");
};

function cargaSelectAlta(){
    var objAjax = $.ajax({
        type:"get",
        url:"./select.php",
        data:{},
        succes: function(respuesta, estado){
            $("#altaEspecialidad").empty();
            console.log(respuesta);
            var objJson = JSON.parse(respuesta);
            console.log(objJson);
            objJson.espec.forEach(function(valor, indice){
                var option = document.createElement("option");
                option.setAttribute("value", valor);
                option.innerHTML = valor;
                document.getElementById("altaEspecialidad").appendChild(option);
            });
        }
    });
}

$(document).ready(function() {
    $("#altaRegistro").click(function() {
        cargaSelectAlta();
    })
})