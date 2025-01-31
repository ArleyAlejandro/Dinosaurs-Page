<?php

class CalendarView
{

    public function __contruct()
    {}

    public function show($mes, $ano, $events = [])
    {
        $this->mostrar_calendario($mes, $ano, $events);
        // $this->formularioCalendario($mes, $ano);
    }

     /**
     * Se encarga de dibujar en pantalla el calendario con todos sus días
     * @param mixed $mes mes a mostrar
     * @param mixed $ano año a mostrar
     * @return void
     */
    public function mostrar_calendario($mes, $ano, $events)
    {
        // Obtengo la fecha actual
        $dia_actual_sistema = date('d'); // Día actual
        $mes_actual_sistema = date('m'); // Mes actual
        $ano_actual_sistema = date('Y'); // Año actual
    
        // Obtengo el nombre del mes
        $nombre_mes = $this->dame_nombre_mes($mes);
    
        echo '<!DOCTYPE html>
        <html lang="es">
                    
        <head>
            <meta charset="UTF-8" />
            <title>Home-Dinosaurios</title>
            <link rel="stylesheet" href="../CSS/Web.css" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="author" content="Arley Rodríguez">
            <meta name="description" content="Actividad Final de Módulo \'Llenguatges de marques i sistemes de gestió d\'informació\'">
        </head>
        <header>
                <h1>Descubriendo el Mundo de los Dinosaurios</h1>
                <nav class="contenedor-menu">
                    <ul class="menu">
                        <li><a href="?" id="inicio">Inicio</a></li>
                        <li><a href="?Caracteristiques/show">Características</a></li>
                        <li><a href="?Conclusion/show">Conclusión</a></li>
                        <li><a href="?login/show">Login</a>
                            <ul>
                                <li><a href="?registro/show">Registro</a></li>
                            </ul>
                        </li>
                        <li><a href="?Bolsa/show">Bolsa</a></li>
                        <li><a href="?Calendar/show">Calendario</a></li>
                        <li><a href="?Mantenimiento/show">Mantenimiento</a></li>
                    </ul>
                </nav>
            </header>
        ';

        // Construyo la tabla general
        echo '<div class="calendar-wrapper"><table class="tablacalendario" cellspacing="3" cellpadding="2" border="0">';
        echo '<tr><td colspan="7" class="tit">';
    
        // Tabla para mostrar el mes, año y controles para pasar al mes anterior y siguiente
        echo '<table class="tabla-interior" width="100%" cellspacing="2" cellpadding="2" border="0"><tr><td class="messiguiente">';
        
        // Calculo el mes y año del mes anterior
        $mes_anterior = $mes - 1;
        $ano_anterior = $ano;
        if ($mes_anterior == 0) {
            $ano_anterior--;
            $mes_anterior = 12;
        }
        echo '<a href="index.php?/Calendar/show/' . $mes_anterior . '/' . $ano_anterior . '"><span class="nb"><<</span></a></td>';
        echo '<td class="titmesano">' . $nombre_mes . " " . $ano . '</td>';
        echo '<td class="mesanterior">';
    
        // Calculo el mes y año del mes siguiente
        $mes_siguiente = $mes + 1;
        $ano_siguiente = $ano;
        if ($mes_siguiente == 13) {
            $ano_siguiente++;
            $mes_siguiente = 1;
        }
        echo '<a href="index.php?/Calendar/show/' . $mes_siguiente . '/' . $ano_siguiente . '"><span class="nb">>></span></a></td>';
    
        // Finalizo la tabla de cabecera
        echo '</tr></table>';
        echo '</td></tr>';
    
        // Fila con todos los días de la semana
        echo '   <tr>
                     <td width="14%" class="diasemana"><span>L</span></td>
                     <td width="14%" class="diasemana"><span>M</span></td>
                     <td width="14%" class="diasemana"><span>X</span></td>
                     <td width="14%" class="diasemana"><span>J</span></td>
                     <td width="14%" class="diasemana"><span>V</span></td>
                     <td width="14%" class="diasemana"><span>S</span></td>
                     <td width="14%" class="diasemana"><span>D</span></td>
                  </tr>';
    
        // Variable para llevar la cuenta del día actual
        $dia_actual = 1;
    
        // Calculo el número del día de la semana del primer día
        $numero_dia = $this->calcula_numero_dia_semana(1, $mes, $ano);
    
        // Calculo el último día del mes
        $ultimo_dia = $this->ultimoDia($mes, $ano);
    
        // Escribo la primera fila de la semana
        echo "<tr>";
        for ($i = 0; $i < 7; $i++) {
            if ($i < $numero_dia) {
                // Si el día de la semana i es menor que el número del primer día de la semana no pongo nada en la celda
                echo '<td class="diainvalido"><span></span></td>';
            } else {
                // Verifico si es el día actual
                if ($dia_actual == $dia_actual_sistema && $mes == $mes_actual_sistema && $ano == $ano_actual_sistema) {
                    // Si es el día actual, asigno una clase CSS especial
                    echo '<td class="diavalido diaactual"><span>' . $dia_actual . '</span></td>';
                } else {
                    // Si no es el día actual, asigno la clase normal
                    echo '<td class="diavalido"><span>' . $dia_actual . '</span></td>';
                }
                $dia_actual++;
            }
        }
        echo "</tr>";
    
        // Recorro todos los demás días hasta el final del mes
        $numero_dia = 0;
        while ($dia_actual <= $ultimo_dia) {
            // Si estamos a principio de la semana, escribo el <TR>
            if ($numero_dia == 0) {
                echo "<tr>";
            }
    
            // Verifico si es el día actual
            if ($dia_actual == $dia_actual_sistema && $mes == $mes_actual_sistema && $ano == $ano_actual_sistema) {
                // Si es el día actual, asigno una clase CSS especial
                echo '<td class="diavalido diaactual"><span>' . $dia_actual . '</span></td>';
            } else {
                // Si no es el día actual, asigno la clase normal
                echo '<td class="diavalido"><span>' . $dia_actual . '</span></td>';
            }
    
            $dia_actual++;
            $numero_dia++;
    
            // Si es el último de la semana, me pongo al principio de la semana y escribo el </tr>
            if ($numero_dia == 7) {
                $numero_dia = 0;
                echo "</tr>";
            }
        }
    
        // Compruebo que celdas me faltan por escribir vacías de la última semana del mes
        for ($i = $numero_dia; $i < 7; $i++) {
            echo '<td class="diainvalido"><span></span></td>';
        }
    
        echo "</tr>";
        echo "</table>";

        echo "<h2>Eventos en " . $this->dame_nombre_mes($mes) . " $ano</h2>";
        if (count($events) > 0) {
            echo "<ul>";
            foreach ($events as $event) {
                echo "<li>{$event['event_title']} - {$event['event_date']}</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No hay eventos para este mes.</p>";
        }

        // Formulario para crear evento
        echo '<h3>Crear Evento</h3>';
        echo '<form action="index.php?/Event/create" method="POST">
                <label for="title">Título</label><br>
                <input type="text" id="title" name="title" required><br><br>
                <label for="date">Fecha</label><br>
                <input type="date" id="date" name="date" required><br><br>
                <label for="description">Descripción</label><br>
                <textarea id="description" name="description"></textarea><br><br>
                <input type="submit" value="Crear Evento">
              </form>';
    }
    

    /**
     * Se encarga de mostrar el formulario para cambiar de mes y año 
     * @param mixed $mes mes a cambiar 
     * @param mixed $ano año a cambiar
     * @return void
     */
    public function formularioCalendario($mes, $ano)
    {
        echo '
           <table align="center" cellspacing="2" cellpadding="2" border="0">
           <tr><form action="index.php" method="POST">';
        echo '
        <td align="center" valign="top">
              Mes: <br>
              <select name=nuevo_mes>
              <option value="1"';
        if ($mes == 1) {
            echo "selected";
        }

        echo '>Enero</option>
              <option value="2" ';
        if ($mes == 2) {
            echo "selected";
        }

        echo '>Febrero</option>
              <option value="3" ';
        if ($mes == 3) {
            echo "selected";
        }

        echo '>Marzo</option>
              <option value="4" ';
        if ($mes == 4) {
            echo "selected";
        }

        echo '>Abril</option>
              <option value="5" ';
        if ($mes == 5) {
            echo "selected";
        }

        echo '>Mayo</option>
              <option value="6" ';
        if ($mes == 6) {
            echo "selected";
        }

        echo '>Junio</option>
              <option value="7" ';
        if ($mes == 7) {
            echo "selected";
        }

        echo '>Julio</option>
              <option value="8" ';
        if ($mes == 8) {
            echo "selected";
        }

        echo '>Agosto</option>
              <option value="9" ';
        if ($mes == 9) {
            echo "selected";
        }

        echo '>Septiembre</option>
              <option value="10" ';
        if ($mes == 10) {
            echo "selected";
        }

        echo '>Octubre</option>
              <option value="11" ';
        if ($mes == 11) {
            echo "selected";
        }

        echo '>Noviembre</option>
              <option value="12" ';
        if ($mes == 12) {
            echo "selected";
        }

        echo '>Diciembre</option>
              </select>
              </td>';
        echo '
            <td align="center" valign="top">
              Año: <br>
              <select name=nuevo_ano>
           ';
       
        //este bucle se podría hacer dependiendo del número de año que se quiera mostrar
        //yo voy a mostar 10 años atrás y 10 adelante de la fecha mostrada en el calendario
        for ($anoactual = $ano - 10; $anoactual <= $ano + 10; $anoactual++) {
            echo '<option value="' . $anoactual . '" ';
            if ($ano == $anoactual) {
                echo "selected";
            }
            echo '>' . $anoactual . '</option>';
        }
        echo '</select>
              </td>';
        echo '
           </tr>
           <tr>
            <td colspan="2" align="center"><input type="Submit" value="[ ir al mes]"></td>
           </tr>
           </table><br>

           <br>

           </form></div>';
    }

    /**
     * calcula el número de día de la semana de una fecha indicada por parámetro
     * @param mixed $dia
     * @param mixed $mes
     * @param mixed $ano
     * @return int
     */
    public function calcula_numero_dia_semana($dia,$mes,$ano){
        $numerodiasemana = date('w', mktime(0,0,0,$mes,$dia,$ano));
        if ($numerodiasemana == 0)
           $numerodiasemana = 6;
        else
           $numerodiasemana--;
        return $numerodiasemana;
    } 

    /**
     * devolver el último día de un mes y año indicados por parámetro
     * @param mixed $mes
     * @param mixed $ano
     * @return int
     */
    public function ultimoDia($mes,$ano){
        $ultimo_dia=28;
        while (checkdate($mes,$ultimo_dia + 1,$ano)){
           $ultimo_dia++;
        }
        return $ultimo_dia;
    }

    /**
     * Devuelve el nombre del mes que recibe como número en el parámetro
     * @param mixed $mes
     * @return string
     */
  public function dame_nombre_mes($mes) {
    $meses = [
        1 => "Enero", 
        2 => "Febrero", 
        3 => "Marzo", 
        4 => "Abril", 
        5 => "Mayo", 
        6 => "Junio", 
        7 => "Julio", 
        8 => "Agosto", 
        9 => "Septiembre", 
        10 => "Octubre", 
        11 => "Noviembre", 
        12 => "Diciembre"
    ];

    return $meses[$mes] ?? "Mes no válido";
}


}
