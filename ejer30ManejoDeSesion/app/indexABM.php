<?php
    session_start();
    if(!isset($_SESSION['sessionId'])) {
        header('location:./../login.html');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MANEJO DE SESION</title>
    <link rel="stylesheet" href="./styles.css">
    <script  src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" ></script>
    <script  src="./script.js"></script>
    <script ></script>
</head>
<body>
    <div id="doc">
        <div class="top">
            <div class="header">
                <header>Turnos</header>
            </div>
                
            <div class="topInput">
                <label for="">Orden:</label>
                <input type="text" id="orden" name="orden" readonly value="IdTurno">
            </div>
            <div class="buttons">
                <button id="endSession" style='cursor: pointer;'>Cerrar sesion</button>
                <button id="altaRegistro" onclick="abrirModalAlta()" style='cursor: pointer;'>Alta registro</button>
                <button id="delete" style='cursor: pointer;'>Borrar</button>
                <button id="load" onclick="cargaTabla();" style='cursor: pointer;'>Cargar datos</button>

            </div>        
                
        </div>
        <div class="tableContainer">

            <table>
                <thead>
                    <tr>
                        <th id="thTurnoId" campo-dato="turnos_IdTurno">Id del turno</th>
                        <th id="thTurnoApDr" campo-dato="turnos_ApellidoDr">Apellido Dr.</th>
                        <th id="thTurnoMat" campo-dato="turnos_Matricula">N° Matricula</th>                    
                        <th id="thTurnoEspec" campo-dato="turnos_Especialidad">Especialidad</th>
                        <th id="thTurnoApPa" campo-dato="turnos_ApellidoPaciente">Apellido del paciente</th>
                        <th id="thTurnoFeTu" campo-dato="turnos_FechaTurno">Fecha hora del turno</th>
                        <th id="thPdf" campo-dato="pdf">PDF</th>
                        <th id="thModis" campo-dato="modis">Modis</th>
                        <th id="thBajas" campo-dato="bajas">Bajas</th>
                    </tr>

                    <tr id="inputsFiltro">
                        <th campo-dato="turnos_IdTurno">
                            <input id="filtroIdTurno"  type="text">
                        </th>
                        <th campo-dato="turnos_ApellidoDr">
                            <input id="filtroApellidoDr"  type="text">
                        </th>
                        <th campo-dato="turnos_Matricula">
                            <input id="filtroMatricula"  type="text">
                        </th>                    
                        <th campo-dato="turnos_Especialidad">
                            <input id="filtroEspecialidad"  type="text">
                        </th>
                        <th campo-dato="turnos_ApellidoPaciente">
                            <input id="filtroApellidoPaciente"  type="text">
                        </th>
                        <th campo-dato="turnos_FechaTurno">
                            <input id="filtroFechaTurno"  type="text">
                        </th>
                        <th campo-dato="pdf"></th>
                        <th campo-dato="modis"></th>
                        <th campo-dato="bajas"></th>
                        
                    </tr>
                </thead>
                
                <tbody id="tbDatos"></tbody>
                
                <tfoot></tfoot>
                
            </table>
        </div>
        <h2 id="cantRegistros"></h2>
        <footer>Pie</footer>
    </div>
    
        <!-- FORMULARIO DE ALTA -->
        <div class="formularioAlta" id="formularioAlta" onchange="todoListoParaAlta()">
            <div class="topElements">
                <header>Encabezado Modal Formulario Alta</header>
                <button onclick="cerrarModalAlta()">X</button>
            </div>
            <form method="post" enctype="multipart/form-data" id="formAlta">
                <div class="col1">
                    <label for="altaID">IdTurno</label>
                    <br>
                    <input type="number" name="altaID" required id="altaID" min="0">
                    <br> 
                    <label for="altaApellidoDr">Apellido Dr.</label>
                    <br>
                    <input type="text" name="altaApellidoDr" requiered id="altaApellidoDr">
                    <br>
                    <label for="altaMatriculaDr">N°Matricula</label>
                    <br>
                    <input type="number" name="altaMatriculaDr" required id="altaMatriculaDr" min="0">
               </div>

                <div class="col2"> 
                    <label for="altaEspecialidad">Especialidad</label>
                    <br>
                    <select class="altaSelec" name="altaEspecialidad" id="altaEspecialidad">
                                <option value="Pediatria">Pediatria</option>
                                <option value="Oftalmologo">Oftalmologo</option>
                                <option value="Psicologia">Psicologia</option>
                                <option value="Urologo">Urologo</option>
                                <option value="Dermatologo">Dermatologo</option>
                    </select>
                    
                    <br>
                    <label for="altaApellidoPaciente">Apellido del paciente</label>
                    <br>
                    <input type="text" name="altaApellidoPaciente" required id="altaApellidoPaciente">
                    <br>
                    <label for="altaFechaTurno">Fecha/Hora del turno</label>
                    <br>
                    <input type="datetime-local" required name="altaFechaTurno" id="altaFechaTurno">
                    <br>
                    <label for="Pdf">PDF:</label>
                    <br>
                    <input type="file" name="Pdf" id="Pdf">
                </div> 
            </form>    
            <button id="altaValidar" class="validButton" disabled  onchange="Alta()">Enviar Alta</button>
        </div>

       
        <!-- FORMULARIO DE MODIFICACION -->
        <div class="formularioAlta" id="formularioModi"> 
            <div class="topElements">
                <header>Encabezado Modal Formulario de Modificacion</header>
                <button onclick="cerrarModalModi()">X</button>
            </div>
            <form method="post" enctype="multipart/form-data" id="formModi">
                <div class="col1">
                    <label for="modiID">IdTurno</label>
                    <br>
                    <input type="number" name="modiID" required readonly id="modiID">
                    <br> 
                    <label for="modiApellidoDr">Apellido Dr.</label>
                    <br>
                    <input type="text" name="modiApellidoDr" requiered id="modiApellidoDr">
                    <br>
                    <label for="modiMatriculaDr">N°Matricula</label>
                    <br>
                    <input type="number" name="modiMatriculaDr" required id="modiMatriculaDr">
                </div>

                <div class="col2">
                    <label for="modiEspecialidad">Especialidad</label>
                    <br>
                    <select class="altaSelec" name="modiEspecialidad" id="modiEspecialidad">
                                <option value="Pediatra">Pediatra</option>
                                <option value="Oftalmologo">Oftalmologo</option>
                                <option value="Psicologia">Psicologia</option>
                                <option value="Urologo">Urologo</option>
                                <option value="Dermatologo">Dermatologo</option>
                    </select>
                    
                    <br>
                    <label for="modiApellidoPaciente">Apellido del paciente</label>
                    <br>
                    <input type="text" name="modiApellidoPaciente" required id="modiApellidoPaciente">
                    <br>
                    <label for="modiFechaTurno">Fecha/Hora del turno</label>
                    <br>
                    <input type="datetime" name="modiFechaTurno"  required id="modiFechaTurno">
                    <br>
                    <label for="modiPDF">PDF:</label>
                    <br>
                    <input type="file" name="modiPDF" id="">        
                </div>
            </form>
            <button id="modiValidar" class="validButton" onclick="ejecutarUpdate()">Enviar Modi</button>
        </div>

        

        <div id="modalRespuesta" class="respuestaServidor">
            <header id="headerModal">Encabezado modal
                <button style="float: right;" onclick="cerrarModalRespuesta()">X</button>
            </header>
            
            <p id="textoResp"></p>
        </div>

        <div id="modalPDF" class="respuestaPDF">
            <header id="headerModal">Encabezado Modal PDF
                <button style="float: right;" onclick="cerrarModalPDF()">X</button>
            </header>
            <div id="contenidoPDF"></div>
        </div>
        
</body>
</html>