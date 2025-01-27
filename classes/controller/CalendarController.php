<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

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

        // Llamar a la vista del calendario con los valores calculados
        $vCalendar = new CalendarView();
        $vCalendar->show($mes, $ano);
    }
}
