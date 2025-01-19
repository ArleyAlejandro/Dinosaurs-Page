<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);
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

        if (empty($params["email"])) {
            $registro->errors["email"] = "El email es obligatorio";
        } else {
            $email = sanitize($params["email"]);
            $registro->__set("email", $email);
        }

        // Instancio un objeto QueryUser para comprobar si el usuario ya existe mediante una consulta a la base de datos
        $queryUser  = new QueryUser();
        $userExists = $queryUser->get($registro->__get('email'));

        // Comprobar si el usuario existe en la base de datos
        if ($userExists) {
            $registro->errors["email"] = "El email ya existe, introduce otro";
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

        if (empty($params["tipoID"])) {
            $registro->errors["tipoID"] = "El tipo de identificación es obligatorio.";
        } else {
            $tipoID = sanitize($params["tipoID"]);
            if (! in_array($tipoID, ['DNI', 'NIE', ''])) {
                $registro->errors["tipoID"] = "El tipo de identificación no es válido.";
            } else {
                $registro->__set("tipoID", $tipoID);
            }
        }

        if (empty($params["num_id"])) {
            $registro->errors["num_id"] = "El número de identificación es obligatorio.";
        } else {
            $numIdUser = sanitize($params["num_id"]);
            $registro->__set("num_id", $numIdUser);
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
                '',
            ])) {
                $registro->errors["sexe"] = "El sexo seleccionado no es válido.";
            } else {
                $registro->__set("sexe", $sex);
            }
        }

        $provincia = sanitize($params["provincia"]);
        $registro->__set("provincia", $provincia);

        $direccion = sanitize($params["direccion"]);
        $registro->__set("direccion", $direccion);

        $codi_postal = sanitize($params["codi_postal"], "int");
        $registro->__set("codi_postal", $codi_postal);

        $poblation = sanitize($params["poblacio"]);
        $registro->__set("poblacio", $poblation);

        // Si el teléfono no está vacío, comprobar que sea válido
       if(!empty($params["telefon"])){
        $tel = sanitize($params["telefon"], "int");
        if (! validateItem($tel, "phone")) {
            $registro->errors["telefon"] = "El teléfono no es válido";
        } else {
            $registro->__set("telefon", $tel);
        }
       }

        // Manejar la subida de la imagen
        if (empty($registro->errors)) {
            if (isset($_FILES['imatge']) && $_FILES['imatge']['error'] !== UPLOAD_ERR_NO_FILE) {
                if ($_FILES['imatge']['error'] === UPLOAD_ERR_OK) {
                    $imagen             = $_FILES['imatge']['name'];
                    $tipoImagen         = $_FILES['imatge']['type'];
                    $tamanyoImagen      = $_FILES['imatge']['size'];
                    $tiposValidos       = ['image/jpeg', 'image/png', 'image/gif'];
                    $extensionesValidas = ['jpg', 'jpeg', 'png', 'gif'];
                    $extensionImagen    = strtolower(pathinfo($imagen, PATHINFO_EXTENSION));

                    if ($tamanyoImagen > 2 * 1024 * 1024) { // 2MB = 2 * 1024 * 1024 bytes
                        $registro->errors['imatge'] = "El tamaño de la imagen no puede exceder los 2MB.";
                    }
                    if (! in_array($tipoImagen, $tiposValidos) || ! in_array($extensionImagen, $extensionesValidas)) {
                        $registro->errors['imatge'] = "Solo se permiten imágenes en formatos JPG, PNG o GIF.";
                    }

                    $directorio             = '../uploads/';
                    $rutaImagen             = $directorio . basename($imagen);

                    if (empty($registro->errors['imatge'])) {
                        if (move_uploaded_file($_FILES['imatge']['tmp_name'], $rutaImagen)) {
                            $_SESSION['imagen'] = $rutaImagen;
                        } else {
                            $registro->errors['imatge'] = "Hubo un error al subir la imagen.";
                        }
                    }
                } else {
                    $registro->errors['imatge'] = "Hubo un error al procesar el archivo.";
                }
            } else {
                $registro->errors['imatge'] = "La imagen es obligatoria.";
            }
        }

        // Si no existen errores guardo los datos en la base de datos
        if (empty($registro->errors)) {

            $data = [
                "name"      => $registro->__get("nom"),
                "lastName"  => $registro->__get("cognoms"),
                "userName"  => $registro->__get("usuari"),
                "email"     => $registro->__get("email"),
                "pass"      => password_hash($registro->__get("contrasenya"), PASSWORD_DEFAULT), // Hash de contraseña
                "typeID"    => $registro->__get("tipoID"),
                "num_id"    => $registro->__get("num_id"),
                "birthdate" => $registro->__get("data_naixement"),
                "gender"    => $registro->__get("sexe"),
                "province"  => $registro->__get("provincia"),
                "address"   => $registro->__get("direccion"),
                "postal"    => $registro->__get("codi_postal"),
                "poblation" => $registro->__get("poblacio"),
                "phone"     => $registro->__get("telefon"),
                "image"     => $_SESSION['imagen'],
            ];

            // Instancia para insertrar los datos en la base de datos
            $admin = new AdminUser();
            $admin->set($data);

            // Redirigir a la página de confirmación
            $vConfirmacion = new ConfirmacionView();
            $vConfirmacion->show();

            // Guardar los datos de sesión
            $_SESSION['usuario'] = $params["email"];
            $_SESSION['contraseña'] = $params["contrasenya"];

        } else {
            $vReg = new RegistroView();
            $vReg->form($registro);
        }
    }
}
