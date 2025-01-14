<?php

// error_reporting(E_ALL);
// ini_set("display_errors", 1);
class RegistroController
{

    public function __construct()
    {}

    public function show($params = null)
    {
        $vReg = new RegistroView();
        $vReg->show();
    }

    public function form($params)
    {
        $registro = new RegistroModel();

        if (empty($params["nom"])) {
            $registro->errors["nom"] = "El nombre es obligatorio";
        } else {
            $name = sanitize($params["nom"]);
            $registro->__set("nom", $name);
        }

        if (empty($params["cognoms"])) {
            $registro->errors["cognoms"] = "Los Apellidos son obligatorios";
        } else {
            $cognoms = sanitize($params["cognoms"]);
            $registro->__set("cognoms", $cognoms);
        }

        if (empty($params["usuari"])) {
            $registro->errors["usuari"] = "El nombre de usuario es obligatorio";
        } else {
            $usuari = sanitize($params["usuari"]);
            $registro->__set("usuari", $usuari);
        }

        if (empty($params["contrasenya"])) {
            $registro->errors["contrasenya"] = "La contraseña es obligatoria.";
        } else {
            $passwd = sanitize($params["contrasenya"]);
            if (strlen($passwd) < 8 || ! preg_match('/[A-Z]/', $passwd) || ! preg_match('/\d/', $passwd)) {
                $registro->errors["contrasenya"] = "La contraseña debe tener al menos 8 caracteres, incluir una letra mayúscula y un número.";
            } else {
                $registro->__set("contrasenya", $passwd);
            }
        }

        if (empty($params["confirma_contrasenya"])) {
            $registro->errors["confirma_contrasenya"] = "La confirmación de contraseña es obligatoria.";
        } else {
            $repeatPassword = sanitize($params["confirma_contrasenya"]);
            if ($registro->__get("contrasenya") !== $repeatPassword) {
                $registro->errors["confirma_contrasenya"] = "Las contraseñas no coinciden.";
            } else {
                $registro->__set("confirma_contrasenya", $repeatPassword);
            }
        }

        if (empty($params["dni"])) {
            $registro->errors["dni"] = "El DNI es obligatorio.";
        } else {
            $dniUser = sanitize($params["dni"]);
            if (! preg_match('/^[0-9]{8}[A-Za-z]$/', $dniUser)) {
                $registro->errors["dni"] = "El DNI no es válido. Debe tener 8 números seguidos de una letra.";
            } else {
                $registro->__set("dni", $dniUser);
            }
        }

        if (! empty($params["data_naixement"])) {
            $date = sanitize($params["data_naixement"]);

            // Verificar que la fecha sea válida en el formato original
            if (! DateTime::createFromFormat('Y-m-d', $date)) {
                $registro->errors["data_naixement"] = "La fecha no es válida";
            } else {
                // Guardar la fecha en formato YYYY-MM-DD (necesario para HTML)
                $registro->__set("data_naixement", $date);
            }
        } else {
            $registro->errors["data_naixement"] = "La fecha es obligatoria";
        }

        if (empty($params["sexe"])) {
            $registro->errors["sexe"] = "El sexo es obligatorio.";
        } else {
            $sex = sanitize($params["sexe"]);
            if (! in_array($sex, [
                'F',
                'M',
                ''
            ])) {
                $registro->errors["sexe"] = "El sexo seleccionado no es válido.";
            } else {
                $registro->__set("sexe", $sex);
            }
        }

        if (empty($params["codi_postal"])) {
            $registro->errors["codi_postal"] = "El código postal es obligatorio";
        } else {
            $codi_postal = sanitize($params["codi_postal"], "int");
            $registro->__set("codi_postal", $codi_postal);
        }

        if (empty($params["poblacio"])) {
            $registro->errors["poblacio"] = "La población es obligatoria";
        } else {
            $poblation = sanitize($params["poblacio"]);
            $registro->__set("poblacio", $poblation);
        }

        if (! empty($params["telefon"])) {
            $tel = sanitize($params["telefon"], "int");
            $registro->__set("telefon", $tel);

            if (! validateItem($tel, "phone")) {
                $registro->errors["telefon"] = "El teléfono no es válido";
            }
        }

        if (empty($registro->errors)) {
            if (isset($_FILES['imatge']) && $_FILES['imatge']['error'] === UPLOAD_ERR_OK) {
                $imagen = $_FILES['imatge']['name'];
                $tipoImagen = $_FILES['imatge']['type'];
                $tamanyoImagen = $_FILES['imatge']['size'];
                $tiposValidos = [
                    'image/jpeg',
                    'image/png',
                    'image/gif'
                ];
                $extensionesValidas = [
                    'jpg',
                    'jpeg',
                    'png',
                    'gif'
                ];
                $extensionImagen = strtolower(pathinfo($imagen, PATHINFO_EXTENSION));

                if ($tamanyoImagen > 2 * 1024 * 1024) { // 2MB = 2 * 1024 * 1024 bytes
                    $registro->errors['imatge'] = "El tamaño de la imagen no puede exceder los 2MB.";
                }
                if (! in_array($tipoImagen, $tiposValidos) || ! in_array($extensionImagen, $extensionesValidas)) {
                    $registro->error['imatge'] = "Solo se permiten imágenes en formatos JPG, PNG o GIF.";
                }
            }

            $directorio = '../uploads/';
            $rutaImagen = $directorio . basename($imagen);
            if (move_uploaded_file($_FILES['imatge']['tmp_name'], $rutaImagen)) {
                // Imagen subida correctamente, almacenamos la ruta
                $_SESSION['imagen'] = $rutaImagen;
            } else {
                $registro->errors['imatge'] = "Hubo un error al subir la imagen.";
            }

            // Crear los usuarios
            $queryUser = new QueryUser();
            $userExists = $queryUser->get($registro->__get('nom'));

            if ($userExists) {
                throw new Exception("Este nombre de usuario ya existe");
            } else {

                $data = [
                    "name" => $registro->__get("nom"),
                    "lastName" => $registro->__get("cognoms"),
                    "userName" => $registro->__get("usuari"),
                    "password" => $registro->__get("contrasenya"),
                    "dni" => $registro->__get("dni"),
                    "phoneNumber" => $registro->__get("telefon")
                ];
                $admin = new AdminUser();
                $admin->set($data);

                $vHome = new HomeView();
                $vHome->show();
            }
        } else {
            $vReg = new RegistroView();
            $vReg->form($registro);
        }
    }
}