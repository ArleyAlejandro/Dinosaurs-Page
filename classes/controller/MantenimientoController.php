<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
class MantenimientoController
{
    
    public function __construct() {}
    
    public function show($params=null) {
        
        $vMantenimiento = new MantenimientoView();
        $vMantenimiento->show();
       
       self::mostrarEventos();

//         $show = new MantenimientoModel();
//         $events = $show->getAll();
//         var_dump($events);
    }
    
    public function form($params){
        $eventForm = new MantenimientoModel();
        
        // Sanatizar y validar datos
        
        // título
        if (empty($params["title"])) {
            $eventForm->errors["title"] = "El título es obligatorio";
        } else {
            $title = sanitize($params["title"]);
            $eventForm->__set("title", $title);
        }
        
        // fecha inicio
        if (!empty($params["startDate"])) {
            $startDate = sanitize($params["startDate"]);
            
            // Verificar que la fecha sea válida en el formato original
            if (! DateTime::createFromFormat('Y-m-d', $startDate)) {
                $eventForm->errors["startDate"] = "La fecha de inicio no es válida";
            } else {
                // Guardar la fecha en formato YYYY-MM-DD (necesario para HTML)
                $eventForm->__set("startDate", $startDate);
            }
        } else {
            $eventForm->errors["startDate"] = "La fecha de inicio es obligatoria";
        }
        
        // hora de inicio
        if (!empty($params["startTime"])) {
            $startTime = sanitize($params["startTime"]);
            
            // Verificar que la hora sea válida en el formato original
            if (! DateTime::createFromFormat('H:i', $startTime)) {
                $eventForm->errors["startTime"] = "La hora de inicio no es válida";
            } else {
                // Guardar la hora de inicio
                $eventForm->__set("startTime", $startTime);
            }
        } else {
            $eventForm->errors["startTime"] = "La hora de inicio es obligatoria";
        }
        
        // fecha fin
        if (!empty($params["endDate"])) {
            $endDate = sanitize($params["endDate"]);
            
            // Verificar que la fecha sea válida en el formato original
            if (! DateTime::createFromFormat('Y-m-d', $endDate)) {
                $eventForm->errors["endDate"] = "La fecha de fin no es válida";
            } else {
                // Guardar la fecha en formato YYYY-MM-DD (necesario para HTML)
                $eventForm->__set("endDate", $endDate);
            }
        } else {
            $eventForm->errors["endDate"] = "La fecha de fin es obligatoria";
        }
        
        // hora de fin
        if (!empty($params["endTime"])) {
            $endTime = sanitize($params["endTime"]);
            
            // Verificar que la hora sea válida en el formato original
            if (! DateTime::createFromFormat('H:i', $endTime)) {
                $eventForm->errors["endTime"] = "La hora de fin no es válida";
            } else {
                // Guardar la hora de fin
                $eventForm->__set("endTime", $endTime);
            }
        } else {
            $eventForm->errors["endTime"] = "La hora de fin es obligatoria";
        }
        
        if (!empty("description")) {
            $description = sanitize($params["description"]);
            $eventForm->__set("description", $description);
            
        }else{
            $eventForm->errors["description"] = "La descripción es obligatoria";
        }
        
        if (!empty("categoria")) {
            $categoria = sanitize($params["categoria"]);
        }

       
        if (empty($eventForm->errors)) {
            
            $data = [
                "title"      => $eventForm->__get("title"),
                "startDate"      => $eventForm->__get("startDate"),
                "startTime"      => $eventForm->__get("startTime"),
                "endDate"      => $eventForm->__get("endDate"),
                "endTime"      => $eventForm->__get("endTime"),
                "description"      => $eventForm->__get("description"),
                "categoria"      => $eventForm->__get("categoria")
                
            ];
            
            $newEvent = new MantenimientoModel();
            $newEvent->createEvent($data);
            
            $showEventView = new MantenimientoView();
            $showEventView->show();
            self::mostrarEventos();
            
        }else{
            $vMantenimiento = new MantenimientoView();
            $vMantenimiento->form($eventForm);
        }
    }
    
    public function mostrarEventos() {
        // Instanciar el modelo
        $mantenimientoModel = new MantenimientoModel();
        
        // Obtener todos los eventos
        $eventos = $mantenimientoModel->getAll();
        
//         echo "<pre>";
//         var_dump($eventos);
//         echo "</pre>";
        
        // Pasar los eventos a la vista
        $mantenimientoView = new MantenimientoView();
        $mantenimientoView->mostrarEventos($eventos);
    }
}

