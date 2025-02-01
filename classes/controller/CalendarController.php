<?php
// error_reporting(E_ALL);
// ini_set("display_errors", 1);

class CalendarController
{
    public function __construct()
    {}
    
    public function show($params)
    {
        // Fecha actual por defecto
        $tiempo_actual = time();
        $mes = date("n", $tiempo_actual);
        $ano = date("Y", $tiempo_actual);
        
        // Sobrescribir valores si los parámetros están presentes
        if (!empty($params) && isset($params[0], $params[1])) {
            // Validar y asignar los parámetros
            $mes = filter_var($params[0], FILTER_VALIDATE_INT) ?: $mes;
            $ano = filter_var($params[1], FILTER_VALIDATE_INT) ?: $ano;
        }
        
        // Instanciar la vista del calendario con el mes y año seleccionados
        $vCalendar = new CalendarView();
        $vCalendar->show($mes, $ano);
        
        // Mostrar eventos del mes seleccionado
        $this->mostrarEventos($mes, $ano);
    }
    
    public function mostrarEventos($mes, $ano) {
        // Obtener el primer y último día del mes seleccionado
        $firstDate = (new DateTime("$ano-$mes-01"))->format('Y-m-d');
        $lastDate = (new DateTime("$ano-$mes-01"))->modify('last day of this month')->format('Y-m-d');
        
        // Instanciar el modelo
        $mantenimientoModel = new MantenimientoModel();
        
        // Obtener los eventos dentro del rango de fechas
        $eventos = $mantenimientoModel->getBetweenDates($firstDate, $lastDate);
        
        // Pasar los eventos a la vista
        $mantenimientoView = new CalendarView();
        $mantenimientoView->mostrarEventos($eventos);
    }
}
