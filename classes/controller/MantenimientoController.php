<?php

// error_reporting(E_ALL);
// ini_set("display_errors", 1);
class MantenimientoController
{

    public function __construct()
    {}

    public function show($params = null)
    {

        // Comprobar si el usuario ya ha iniciado sesión, para permitirle el acceso a la página de mantenimiento
        if (isset($_SESSION['usuario_logueado']) and $_SESSION['usuario_logueado'] === true) {
            // Se muestra la página de mantenimiento y sus eventos
            $vMantenimiento = new MantenimientoView();
            $vMantenimiento->show();
            self::mostrarEventos();
        } else {
            // Se crea un mensaje de redirección para mostrarlo en el login ( "Debe iniciar sesión para
            // acceder a la página de Mantenimiento" )
            $_SESSION['mensajeDeRedireccion'] = true;

            // Se redirige a la pág de Login para q se inicie sesión
            header("Location: ?Login/show");
            exit();
        }
    }

    public function form($params = null)
    {
        $eventForm = new MantenimientoModel();

        // Sanatizar y validar datos del formulario para crear eventos
        self::validateFields($eventForm, $params);

        // Si no hay errores creo el evento
        if (empty($eventForm->errors)) {

            $data = [
                "title" => $eventForm->__get("title"),
                "startDate" => $eventForm->__get("startDate"),
                "startTime" => $eventForm->__get("startTime"),
                "endDate" => $eventForm->__get("endDate"),
                "endTime" => $eventForm->__get("endTime"),
                "description" => $eventForm->__get("description"),
                "categoria" => $eventForm->__get("categoria")
            ];

            self::crearEvento($eventForm, $data);

            // echo "<pre>";
            // var_dump($params);
            // echo "</pre>";

            // Recibir el id desde parámetros
            if (! empty($params) && isset($params[0])) {

                $id = filter_var($params[0], FILTER_VALIDATE_INT) ?: $id;

                // Cargar el evento desde la base de datos
                $eventModel = new MantenimientoModel();
                $event = $eventModel->getOneById($id);

                // Si el evento existe, actualizar
                if ($event) {
                    // Actualizar evento en la base de datos
                    $eventModel->updateEvent($id, $data);

                    // Luego de actualizar, redirigir a la vista de eventos
                    header("Location: ?Mantenimiento/show");
                    exit();
                } else {
                    // Redirigir si el evento no se encuentra
                    header("Location: ?Mantenimiento/show");
                    exit();
                }
            }

            // Si hay errores muestro el formulario con los errores
        } else {
            $vMantenimiento = new MantenimientoView();
            $vMantenimiento->form($eventForm);
            self::mostrarEventos();
        }
    }

    public function crearEvento(MantenimientoModel $eventForm, $data)
    {
        $newEvent = new MantenimientoModel();
        $newEvent->createEvent($data);

        // Redirigir a la vista de eventos después de la creación
        header("Location: ?Mantenimiento/show");
        exit();
    }

    public function mostrarEventos()
    {
        $mantenimientoModel = new MantenimientoModel();
        $eventos = $mantenimientoModel->getAll();

        // Pasar los eventos a la vista
        $mantenimientoView = new MantenimientoView();
        $mantenimientoView->mostrarEventos($eventos);
    }

    public function deleteOne($params)
    {

        // Recibir el id desde parámetros
        if (! empty($params) && isset($params[0])) {
            $id = filter_var($params[0], FILTER_VALIDATE_INT) ?: $id;
        }

        // Instanciar el modelo
        $mantenimientoModel = new MantenimientoModel();

        // Ejecutar la eliminación
        $mantenimientoModel->deleteOne($id);

        // Redirigir para q se vuelva a cargar la página
        header("Location: ?Mantenimiento/show");
        exit();
    }

    public function updateOne($params)
    {
        $id = filter_var($params[0], FILTER_VALIDATE_INT);
        // Cargar el evento desde la base de datos
        $eventModel = new MantenimientoModel();
        $event = $eventModel->getOneById($id);

        // Verificar si el evento existe
        if (isset($event)) {

            $view = new MantenimientoView();
            $view->updateOne($event);
            $view->mostrarEventos($event);

            // Si el formulario fue enviado y no hay errores, actualizar el evento
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Recoger los datos del formulario
                $data = [

                    "title" => $_POST['title'],
                    "startDate" => $_POST['startDate'],
                    "startTime" => $_POST['startTime'],
                    "endDate" => $_POST['endDate'],
                    "endTime" => $_POST['endTime'],
                    "description" => $_POST['description'],
                    "categoria" => $_POST['categoria']
                ];

                // Validar los datos si es necesario
                self::validateFields($eventModel, $data);

                // Si no hay errores, hacer el update
                if (empty($eventModel->errors)) {

                    if ($_POST['id']) {
                        $eventModel->updateEvent($_POST['id'], $data);

                        header("Location: ?Mantenimiento/show");
                        exit();
                    }
                }
            }
        } else {

            // Redirigir si no se encuentra el evento
            header("Location: ?Mantenimiento/show");
            exit();
        }
    }

    public function validateFields(MantenimientoModel $eventForm, $params)
    {
        // título
        if (empty($params["title"])) {
            $eventForm->errors["title"] = "El título es obligatorio";
        } else {
            $title = sanitize($params["title"]);
            $eventForm->__set("title", $title);
        }

        // fecha inicio
        if (! empty($params["startDate"])) {
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
        if (! empty($params["startTime"])) {
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

        // Fecha de fin
        if (! empty($params["endDate"])) {
            $endDate = sanitize($params["endDate"]);

            if (! DateTime::createFromFormat('Y-m-d', $endDate)) {
                $eventForm->errors["endDate"] = "La fecha de fin no es válida";
            } else {
                // Convertir ambas fechas a objetos DateTime
                $inicio = new DateTime($startDate);
                $fin = new DateTime($endDate);

                // Validar que la fecha de fin no sea anterior a la de inicio
                if ($fin < $inicio) {
                    $eventForm->errors["endDate"] = "La fecha de fin no puede ser anterior a la fecha de inicio.";
                } else {
                    $eventForm->__set("endDate", $endDate);
                }
            }
        } else {
            $eventForm->errors["endDate"] = "La fecha de fin es obligatoria";
        }

        // hora de fin
        if (! empty($params["endTime"])) {
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

        if (! empty($params["description"])) {
            $description = sanitize($params["description"]);
            $eventForm->__set("description", $description);
        } else {
            $eventForm->errors["description"] = "La descripción es obligatoria";
        }

        if (! empty($params["categoria"])) {
            $categoria = sanitize($params["categoria"]);
            $eventForm->__set("categoria", $categoria);
        }
    }
}

