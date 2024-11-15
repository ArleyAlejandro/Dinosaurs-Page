<?php 
session_start(); 
// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bolsa</title>
    <link rel="stylesheet" href="../CSS/Web.css">
</head>
<body class="bolsa">

<?php
session_start();

// Manejo del idioma en la sesión y cookie
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idioma'])) { 
    $idioma = $_POST['idioma'];
    $_SESSION['idioma'] = $idioma;
    setcookie('idioma', $idioma, time() + (86400 * 30), "/");
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

/* Comprobar si el idioma está guuardado en la sesión o en una cookie, 
 * si no es el caso, se guarda un idioma por defecto*/
$idioma = $_SESSION['idioma'] ?? $_COOKIE['idioma'] ?? 'es';

if ($idioma === 'en') {
    include 'lang/en.php';
} else {
    include 'lang/es.php';
}

// Array con los elementos de la cabezera de la tabla.
$datosCabezera = [
    "nom", "ticker", "mercat", "ultima_coti", "divisa", 
    "variacio", "variacio_percent", "volum", "minim", 
    "maxim", "data", "hora"
];

$url = "https://www.inversis.com/inversiones/productos/cotizaciones-nacionales&pathMenu=3_1_0_0&esLH=N";
$texto = file_get_contents($url);

preg_match_all('/<tr id="tr_\d+".*?>.*?<\/tr>/s', $texto, $tr);
$array = [];

foreach ($tr[0] as $tr) {
    preg_match_all('/<td.*?>(.*?)<\/td>/s', $tr, $td);
    $columnas_limpias = array_map(function ($columna) {
        return trim(str_replace('&nbsp;', ' ', strip_tags($columna)));
    }, $td[1]);
    $array[] = $columnas_limpias;
}

eliminaElementoEnFila($array);
$array = agregaIndice($array, $datosCabezera);

function eliminaElementoEnFila(&$array)
{
    foreach ($array as &$fila) {
        unset($fila[3]);
        if (isset($fila[13])) {
            unset($fila[13]);
        }
        if (isset($fila[14])) {
            unset($fila[14]);
        }
    }
}

function agregaIndice($array, $arrayIndices)
{
    $nuevoArray = [];
    foreach ($array as $fila) {
        $nuevoArray[] = array_combine($arrayIndices, $fila);
    }
    return $nuevoArray;
}

// Cargar el último valor de "ultima_coti" de la sesión, si existe
$valores_anteriores = $_SESSION['valores_anteriores'] ?? ['ultima_coti' => null];

function html_pintaTabla($datosCabezera, $array, $lang, &$valores_anteriores) {
    $capcelera = "<tr>\n";
    $cos = "<tbody>\n";
    
    // Generar la cabecera
    foreach ($datosCabezera as $th) {
        $capcelera .= "<th>" . htmlspecialchars($lang[$th]) . "</th>";
    }
    $capcelera .= "</tr>\n";
    
    // Generar el cuerpo de la tabla
    foreach ($array as $subarray) {
        $cos .= "<tr>";
        
        foreach ($subarray as $index => $celdas) {
            $colorFondo = '';
            $colorTexto = '';
            
            // Convertir valor a formato decimal para comparaciones
            $valor = trim(str_replace(',', '.', strip_tags($celdas)));
            
            // Lógica de colores de fondo y texto
            if ($index === 'ultima_coti') {
                // Compara el valor actual con el valor anterior de "ultima_coti"
                if (isset($valores_anteriores[$index]) && $valores_anteriores[$index] !== null) {
                    if ($valor > $valores_anteriores[$index]) {
                        $colorFondo = 'bgGreen';
                    } elseif ($valor < $valores_anteriores[$index]) {
                        $colorFondo = 'bgRed';
                    }
                }
                $valores_anteriores[$index] = $valor; // Actualizar el valor anterior
            } elseif ($index === 'variacio' || $index === 'variacio_percent') {
                // Color de texto basado en el valor de "variacio" o "variacio_percent"
                $colorTexto = $valor < 0 ? 'red' : 'green';
            }
            
            // Crear la celda con los colores aplicados
            $claseFondo = $colorFondo ? " class=\"$colorFondo\"" : '';
            $claseTexto = $colorTexto ? " style=\"color:$colorTexto;\"" : '';
            $cos .= "<td$claseFondo$claseTexto>" . htmlspecialchars($celdas) . "</td>";
        }
        
        $cos .= "</tr>\n";
    }
    
    // Ensamblar la tabla final
    $resultat = "<table>\n<thead>$capcelera</thead>\n$cos</tbody>\n</table>";
    
    return $resultat;
}

echo html_pintaTabla($datosCabezera, $array, $lang, $valores_anteriores);
// Guardar los valores en sesión para la próxima carga de la página
$_SESSION['valores_anteriores'] = $valores_anteriores;

?>

<aside>
    <form method="POST" action="">
        <label for="idioma"><?php echo $lang['select_language']; ?></label>
        <select name="idioma" id="idioma">
            <option value="es" <?php if ($idioma === 'es') echo 'selected'; ?>>Español</option>
            <option value="en" <?php if ($idioma === 'en') echo 'selected'; ?>>English</option>
        </select>
        <button type="submit"><?php echo $lang['save']; ?></button>
        <button type="button" onclick="location.reload();"><?php echo $lang['refresh']; ?></button>
        <a id="back-to-home" href="Home.php">Volver al Home</a> 
    </form>
</aside>
<?php // Llamar a la función para pintar la tabla y guardar los valores en sesión
pintaTabla($datosCabezera, $array, $lang, $valores_anteriores);?>
</body>
</html>