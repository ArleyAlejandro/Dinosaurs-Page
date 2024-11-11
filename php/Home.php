<?php
$formDisplay = 'style="display: block;"';
$nombreError = $passwordError = $emailError = $comentariosError = "";

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userLog = false;

    function sanatizar($datos)
    {
        // Eliminar espacios en blanco (también conocido como trim)
        $datos = trim($datos);
        // Eliminar barras invertidas
        $datos = stripslashes($datos);
        // Convertir caracteres especiales a entidades HTML
        $datos = htmlspecialchars($datos, ENT_QUOTES, 'UTF-8');
        return $datos;
    }

    // Comprobar si no se ha rellenado el campo obligatorio para mostrar mensajes de error
    if (empty($_POST["nombre"])) {
        $nombreError = "Este campo es obligatorio";
        // Si se ha rellenado, limpio los datos de posibles entradas maliciosas
    } else {
        $nombre = sanatizar($_POST['nombre']);
    }

    function validarContrasena($contrasena)
    {
        // Validar longitud mínima de 8 caracteres
        if (strlen($contrasena) < 8) {
            return false;
        }
        // Validar si contiene al menos una letra mayúscula
        if (! preg_match('/[A-Z]/', $contrasena)) {
            return false;
        }
        // Validar si contiene al menos una letra minúscula
        if (! preg_match('/[a-z]/', $contrasena)) {
            return false;
        }
        // Validar si contiene al menos un número
        if (! preg_match('/[0-9]/', $contrasena)) {
            return false;
        }
        // Validar si contiene al menos un carácter especial
        if (! preg_match('/[\W_]/', $contrasena)) {
            return false;
        }

        // Si cumple con todos los requisitos, devuelve true
        return true;
    }
    // Comprobar si no se ha rellenado el campo obligatorio para mostrar mensajes de error
    if (empty($_POST["password"])) {
        $passwordError = "Este campo es obligatorio";
    } elseif (! validarContrasena($_POST["password"])) {
        $passwordError = "Contraseña inválida";
        $password = "";
    } else {
        $password = sanatizar($_POST['password']);
    }

    // Comprobar si no se ha rellenado el campo obligatorio para mostrar mensajes de error
    if (empty($_POST["email"])) {
        $emailError = "Este campo es obligatorio";
        // Si se ha rellenado, limpio los datos de posibles entradas maliciosas
    } else {
        $email = sanatizar($_POST['email']);
        // Comprobar que el email es válido
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailError = "Email inválido";
        }
    }

    $fecha = sanatizar($_POST['birthday']);
    $comentarios = sanatizar($_POST['comentarios']);

    // Comprobar si no se ha rellenado el campo obligatorio para mostrar mensajes de error
    if (empty($_POST["comentarios"])) {
        $comentariosError = "Este campo es obligatorio";
        // Si se ha rellenado, limpio los datos de posibles entradas maliciosas
    } else {
        $comentarios = sanatizar($_POST['comentarios']);
    }

    // Guardar la fecha y hora de envio del formulario
    $fecha = date("j/m/Y h:i a");

    // Crear contenido XML
    $contenidoXML = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    $contenidoXML .= "<datos>\n";
    $contenidoXML .= "  <nombre>" . $nombre . "</nombre>\n";
    $contenidoXML .= "  <password>" . $password . "</password>\n";
    $contenidoXML .= "  <email>" . $email . "</email>\n";
    $contenidoXML .= "  <fechaNacimiento>" . $fecha . "</fechaNacimiento>\n";
    $contenidoXML .= "  <comentarios>" . $comentarios . "</comentarios>\n";
    $contenidoXML .= "  <fechaDeEnvio>" . $fecha . "</fechaDeEnvio>\n";
    $contenidoXML .= "</datos>\n";

    // Guardar el nombre del fichero en una variable, para abrirlo y escribir en él
    $filename = './usuario.xml';

    /**
     * Función para escribir los datos introducidos en un fichero
     *
     * @param string $fichero
     *            Fichero donde se guardarán los datos
     * @param mixed $contenido
     *            Contenido a escribir en el fichero
     */
    function escribeFichero($fichero, $contenido)
    {
        // Intentar abrir el archivo si es escribible, o crearlo si no existe
        if (is_writable($fichero) || ! file_exists($fichero)) {
            // Abrir en modo de escritura (creará el archivo si no existe)
            $ficheroPuntero = fopen($fichero, 'w');
            // Escribir en el fichero
            fwrite($ficheroPuntero, $contenido);
            // Cerrar en el fichero
            fclose($ficheroPuntero);
        } else {
            echo "El archivo $fichero no es escribible";
        }
    }

    // Mostrar mensaje según si se han rellenado o no los campos obligatorios
    $mensaje = (empty($nombreError) && empty($passwordError) && empty($emailError) && empty($comentariosError)) ? "Formulario enviado correctamente." : "Campos obligatorios no rellenados";
    echo "<script>alert('$mensaje');</script>";

    // Solo guardar los datos si no hay errores, para evitar contenido malicioso
    if (empty($nombreError) && empty($passwordError) && empty($emailError) && empty($comentariosError)) {
        // Escribir la información del formulario en el fichero xml
        escribeFichero($filename, $contenidoXML);
        // Al enviar el formulario vacío los camposSSS
        $nombre = $apellido = $email = $fecha = $comentarios = "";
        $userLog = true;
    }

    if ($userLog) {
        $formDisplay = 'style="display: none;"';
        $formButton = '<div class="uiverse" id="closeSession"><span class="tooltip">Adios!!</span>
                       <a href="Home.php">Cerrar sesión</a></div>';
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8" />
<title>Home-Dinosaurios</title>
<link rel="stylesheet" href="../CSS/Web.css" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="author" content="Arley Rodríguez">
<meta name="description"
	content="Actividad Final de Módulo 'Llenguatges de marques i sistemes de gestió d'informació'">
</head>

<body>
	<div class="contenedor">
		<div class="menu-nav">
			<header>
				<h1>Descubriendo el Mundo de los Dinosaurios</h1>
				<nav class="contenedor-menu">
					<ul class="menu">
						<li><a href="Home.php" id="inicio">Inicio</a>
							<ul>
								<li><a href="Home.php#origen">Orígen y Evolución</a></li>
								<li><a href="Home.php#form">Formulario</a></li>
								<li><a href="Home.php#populares">Populares</a></li>
								<li><a href="">Podría Interesarte</a>
									<ul>
										<li><a
											href="https://www.google.com/url?sa=t&rct=j&q=&esrc=s&source=web&cd=&cad=rja&uact=8&ved=2ahUKEwiD5_iD4diEAxU4UqQEHcIECO8QFnoECBEQAQ&url=https%3A%2F%2Fwww.edx.org%2Fes%2Faprende%2Fdinosaurios&usg=AOvVaw22EF64fQkyKFLornvKiTnC&opi=89978449"
											target="_blank">edx</a></li>
										<li><a
											href="https://www.google.com/url?sa=t&rct=j&q=&esrc=s&source=web&cd=&cad=rja&uact=8&ved=2ahUKEwiD5_iD4diEAxU4UqQEHcIECO8QFnoECBMQAQ&url=https%3A%2F%2Fpequesynenes.wixsite.com%2Fadoradaspequeneces%2Fsingle-post%2Faprendiendo-sobre-los-dinosaurios&usg=AOvVaw3v0-Aweke5OU4BRLXZRV7O&opi=89978449"
											target="_blank">Wix</a></li>
										<li><a
											href="https://www.google.com/url?sa=t&rct=j&q=&esrc=s&source=web&cd=&cad=rja&uact=8&ved=2ahUKEwiD5_iD4diEAxU4UqQEHcIECO8QFnoECDAQAQ&url=https%3A%2F%2Fquecamandiles.com%2Fdinosaurios-apps%2F&usg=AOvVaw2LEtmZzxhY7HpXC5xDc0xl&opi=89978449"
											target="_blank">Queca Mandiles</a></li>
										<li><a
											href="https://www.google.com/url?sa=t&rct=j&q=&esrc=s&source=web&cd=&cad=rja&uact=8&ved=2ahUKEwiD5_iD4diEAxU4UqQEHcIECO8QFnoECDIQAQ&url=https%3A%2F%2Fintef.es%2Fexperiencias_edu%2Flos-dinosaurios%2F&usg=AOvVaw1wRC9jqocs8efhIGNydVlH&opi=89978449"
											target="_blank">INTEF</a></li>
									</ul></li>
							</ul></li>
						<li><a href="Hom2.php">Características</a>
							<ul>
								<li><a href="Hom2.php#top">Top 10</a></li>
								<li><a href="Hom2.php#Adaptaciones">Adaptaciones</a></li>

							</ul></li>
						<li><a href="Home3.php">Conclusión</a>

							<ul>
								<li><a href="Home3.php#caja-para-galeria-css">Galería</a></li>
								<li><a href="Home3.php#extincion">Extinción</a></li>
								<li><a href="Home3.php#tabla-1">Tabla de Carnívoros</a></li>
								<li><a href="Home3.php#tabla-2">Tabla de Hervívoros</a></li>
								<li><a href="Home3.php#legado-des">Legado y Descubrimientos</a></li>
							</ul></li>
						<li><a href="bolsa.php">Bolsa</a>
					
					</ul>
				</nav>
			</header>
		</div>

		<div class="menu-principal">
			<main>
				<h2>Introducción</h2>
				<p>
					Los dinosaurios, criaturas fascinantes y majestuosas que poblaron
					la Tierra durante más de 160 millones de años, han capturado la
					imaginación de científicos y entusiastas por igual. Desde los
					enormes <a href="https://es.wikipedia.org/wiki/Sauropoda"
						target="_blank">saurópodos</a> que vagaban por paisajes
					prehistóricos hasta los ágiles <a
						href="https://prehistoria.fandom.com/es/wiki/Theropoda"
						target="_blank">terópodos</a> que cazaban en manadas, los
					dinosaurios representan una de las historias más extraordinarias de
					la evolución en nuestro planeta.
				</p>
				<p>En esta exploración, nos sumergiremos en el vasto mundo de los
					dinosaurios, desde sus humildes orígenes hasta su extinción
					catastrófica. Descubriremos cómo estos antiguos reptiles
					evolucionaron y se diversificaron, desarrollando una asombrosa
					variedad de formas y adaptaciones para sobrevivir en una Tierra en
					constante cambio.</p>
				<img src="../IMG/Mosasaurio.jpg" alt="Mosasaurio en el lecho marino"
					class="img-home1">
				<p>A través de la clasificación de los dinosaurios, desentrañaremos
					los misterios de sus distintos grupos, desde los imponentes
					saurópodos hasta los espinosos estegosaurios. Exploraremos sus
					características físicas, sus comportamientos y su papel en los
					ecosistemas prehistóricos, mientras intentamos comprender cómo
					estas criaturas dominaron el planeta durante millones de años.</p>
				<p>
					Sin embargo, la historia de los dinosaurios también está marcada
					por su misteriosa desaparición al final del <a
						href="https://es.wikipedia.org/wiki/Cret%C3%A1cico"
						target="_blank">período Cretácico</a>, un evento que cambió el
					curso de la evolución en la Tierra y dejó un legado duradero. A
					través de la paleontología moderna, continuamos desenterrando
					secretos enterrados en el tiempo, revelando nuevas ideas sobre
					estos antiguos habitantes de nuestro planeta y su impacto en el
					mundo moderno.
				</p>
				<p>
					Únete a nosotros en este viaje a través de los siglos, mientras
					exploramos el
					<mark>fascinante mundo de los dinosaurios</mark>
					y desenterramos los misterios que yacen bajo nuestros pies desde
					tiempos inmemoriales.
				</p>
				<img src="../IMG/pangea2.webp" alt="Pangea" class="img-home1">
			</main>

			<aside>
			<?php echo $formButton ?? ''?>
				<!-- Este div es oara poder darle propiedades al formulario en conjunto con el h3 -->
				<div class="formulario" <?php echo $formDisplay?>>
					<h3 id="form">Login</h3>
					<p class="forms">Iniciar sesión</p>
					<form action="#" method="post" id="registro">
						<fieldset>
							<legend>Datos Básicos</legend>
							<div class="label-field">
								<input type="text" name="nombre" id="usuario-nombre"
									autofocus="autofocus" value="<?php echo $nombre; ?>"> <label
									for="usuario-nombre">Nombre:<span style="color: red;">(*)</span>
								 <?php if (!empty($nombreError)) { echo '<span class="error" style="white-space: nowrap; color: red;">' . $nombreError . '</span>'; } ?></label>
							</div>
							<div class="label-field">
								<input type="password" name="password" id="usuario-password"
									value="<?php echo $password; ?>"> <label for="usuario-password">Contraseña:<span
									style="color: red;">(*)</span> <span class="error"
									style="white-space: nowrap; color: red;"><?php echo $passwordError; ?></span></label>
							</div>
							<div class="label-field">
								<input type="text" name="email" id="usuari"
									value="<?php echo $email; ?>"> <label for="usuari">Email:<span
									style="color: red;">(*)</span> <span class="error"
									style="white-space: nowrap; color: red;"><?php echo $emailError; ?></span></label></label>
							</div>
							<div class="label-field">
								<input type="date" id="birthday" name="birthday"
									value="<?php echo $fecha; ?>"> <label for="birthday">Fecha de
									Nacimiento:</label>
							</div>
						</fieldset>

						<fieldset>
							<legend>Feedback</legend>
							<div class="label-field">
								<textarea id="comentarios" name="comentarios" maxlength="255"><?php echo htmlspecialchars($comentarios); ?></textarea>
								<label for="comentarios">Háblanos sobre ti:<span
									style="color: red;">(*)</span> <span class="error"
									style="white-space: nowrap; color: red;"><?php echo $comentariosError; ?></span></label></label></label>
							</div>
						</fieldset>
						<footer>
							<input type="submit" value="enviar">
						</footer>
					</form>
				</div>


				<div class="lista">
					<h2 id="populares">Populares</h2>
					<ol>
						<li><a href="Hom2.php#Spinosaurus">Spinosaurus</a></li>
						<li><a href="Hom2.php#Giganotosaurus">Giganotosaurus</a></li>
						<li><a href="Hom2.php#Tyrannosaurus">Tyrannosaurus</a></li>
						<li><a href="Hom2.php#Triceratops">Triceratops</a></li>
						<li><a href="Hom2.php#Stegosaurus">Stegosaurus</a></li>
						<li><a href="Hom2.php#Ankylosaurus">Ankylosaurus</a></li>
						<li><a href="Hom2.php#Diplodocus">Diplodocus</a></li>
						<li><a href="Hom2.php#Suchomimus">Suchomimus</a></li>
						<li><a href="Hom2.php#Pterodáctilos">Pterodáctilos</a></li>
						<li><a href="Hom2.php#Archaeopteryx">Archaeopteryx</a></li>
					</ol>
				</div>

			</aside>
		</div>
		<section id="origen">
			<h2>Orígen y Evolución</h2>

			<p>
				Los dinosaurios, como grupo, surgieron en un momento crucial en la
				historia evolutiva de la Tierra, conocido como el <a
					href="https://es.wikipedia.org/wiki/Tri%C3%A1sico" target="_blank">período
					Triásico</a>, hace aproximadamente 230 millones de años. Su
				aparición marcó un cambio significativo en la fauna terrestre, y
				eventualmente llegarían a dominar los ecosistemas terrestres durante
				millones de años.
			</p>

			<p>Los antepasados de los dinosaurios eran reptiles arcosaurios, un
				grupo que también incluía a los cocodrilos y aves. A partir de estos
				ancestros, los dinosaurios evolucionaron características únicas que
				los distinguían de otros reptiles. Una de estas características
				clave fue la postura erecta de las extremidades, que les permitió
				moverse de manera más eficiente y desarrollar una locomoción más
				activa.</p>

			<p>Durante el Triásico, los primeros dinosaurios se diversificaron
				rápidamente en una variedad de formas y tamaños. Se han descubierto
				fósiles que representan tanto a los primeros dinosaurios carnívoros
				como a los herbívoros. Esta diversificación inicial estableció las
				bases para el éxito posterior de los dinosaurios en una variedad de
				nichos ecológicos.</p>
			<img src="../IMG/grupo-dinos.png"
				alt="Manada de dinosaurios un poco raros" class="img-home1">
			<p>A medida que avanzaba el tiempo geológico, los dinosaurios
				continuaron evolucionando y adaptándose a diferentes ambientes y
				estilos de vida. Se desarrollaron grupos especializados, como los
				terópodos carnívoros y los saurópodos herbívoros, cada uno con
				características únicas adaptadas a su dieta y comportamiento.</p>

			<p>Uno de los hitos más significativos en la evolución de los
				dinosaurios fue su ascenso a la dominancia durante el período
				Jurásico, aproximadamente hace 200 millones de años. Durante esta
				época, los dinosaurios alcanzaron su máximo apogeo en términos de
				diversidad y tamaño, con especies como el Brachiosaurus y el
				Allosaurus prosperando en una variedad de hábitats en todo el mundo.</p>

			<p>Sin embargo, los dinosaurios también experimentaron desafíos a lo
				largo de su historia, incluidos cambios climáticos, competencia con
				otros grupos de animales y eventos de extinción. A pesar de estos
				desafíos, los dinosaurios lograron sobrevivir y adaptarse durante
				millones de años, hasta que un evento catastrófico marcó su final
				abrupto al final del período Cretácico, hace aproximadamente 65
				millones de años.</p>

			<p>Aunque los dinosaurios se extinguieron, su legado perdura hasta el
				día de hoy. Los descendientes de los dinosaurios, las aves modernas,
				son testigos vivientes de su increíble linaje y continúan
				demostrando la asombrosa capacidad de adaptación que caracterizó a
				sus antepasados. La historia de los dinosaurios es un recordatorio
				poderoso de la incesante marcha del tiempo y la constante evolución
				de la vida en nuestro planeta.</p>
		</section>
		<div class="botones">
			<a href="Home.php" class="boton-retorno">Volver </a> <a
				href="Hom2.php" class="boton-siguiente">Siguiente</a>
		</div>

		<footer>
			<div>
				<img src="../IMG/whitelogo.png" alt="Logo del instituto ThosICodina">
				<p>Riera de Cirera, 57 - 08304, Mataró</p>
				<p>Telèfon: 937 414 203</p>
				<a href="http://www.iesthosicodina.cat/">http://www.iesthosicodina.cat</a>
				<a href="http://www.iesthosicodina.cat/contacte/">Contacteu amb el
					centre</a>
			</div>
			<div id="CopyR">
				<p>© 2024 Todos los derechos reservados.</p>
				<p>
					<img id="css-valido"
						src="http://jigsaw.w3.org/css-validator/images/vcss-blue"
						alt="¡CSS Válido!" />
				</p>

			</div>
		</footer>
	</div>
</body>

</html>