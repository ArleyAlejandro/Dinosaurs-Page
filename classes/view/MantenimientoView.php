<?php

class MantenimientoView
{

    public function __construct()
    {}

    public function show()
    {
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
 <body> <div class="contenedor"> 
        <div class="menu-nav">
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
                        <li><a href="?Bolsa/show"> Bolsa </a></li>
                        <li><a href="?Calendar/show"> Calendario </a></li>
                        <li><a href=""> Mantenimiento </a></li>
                    </ul>
                </nav>
            </header>
  </div>
        ';

        // Formulario para crear evento
        echo '<div class="flex">

        <form action="" method="POST">
            <label for="title">Título</label><br>
            <input type="text" id="title" name="title" ><br><br>
        
            <label for="startDate">Fecha inicio</label><br>
            <input type="date" id="startDate" name="startDate" ><br><br>
        
            <label for="startTime">Hora inicio</label><br>
            <input type="time" id="startTime" name="startTime" ><br><br>
        
            <label for="endDate">Fecha fin</label><br>
            <input type="date" id="endDate" name="endDate" ><br><br>
        
            <label for="endTime">Hora fin</label><br>
            <input type="time" id="endTime" name="endTime" ><br><br>
        
            <label for="description"> Descripción </label><br>
            <textarea id="description" name="description"></textarea><br><br>
        
            <label for="categoria">Categoría</label><br>
            <input type="text" id="categoria" name="categoria"><br><br>
        
            <input type="submit" value="Crear Evento">
        </form>

        </body>
    </html>';
    }
    
    public function form(MantenimientoModel $event){
        $title = $event->__get('title') ?? '';
        $startDate = $event->__get('startDate') ?? '';
        $startTime = $event->__get('startTime') ?? '';
        $endDate = $event->__get('endDate') ?? '';
        $endTime = $event->__get('endTime') ?? '';
        $description = $event->__get('description') ?? '';
        $categoria = $event->__get('categoria') ?? ''; 
        
        $errors = $event->errors; 
        
        ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Página de registro</title>
    <link rel="stylesheet" href="../CSS/Web.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
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
                <li><a href="?Bolsa/show"> Bolsa </a></li>
                <li><a href="?Calendar/show"> Calendario </a></li>
                <li><a href=""> Mantenimiento </a></li>
            </ul>
        </nav>
     </header>
		<div class="flex">
        <form action="" method="POST">
            <label for="title">Título</label><br>
            <input type="text" id="title" name="title" value="<?= htmlspecialchars($title); ?>"><br>
         	<?= !empty($errors['title']) ? "<p class='error'>{$errors['title']}</p>" : '' ?>
        
            <label for="startDate">Fecha inicio</label><br>
            <input type="date" id="startDate" name="startDate" value="<?= htmlspecialchars($startDate); ?>"><br>
            <?= !empty($errors['startDate']) ? "<p class='error'>{$errors['startDate']}</p>" : '' ?>
        
            <label for="startTime">Hora inicio</label><br>
            <input type="time" id="startTime" name="startTime" value="<?= htmlspecialchars($startTime); ?>"><br>
			<?= !empty($errors['startTime']) ? "<p class='error'>{$errors['startTime']}</p>" : '' ?>
        
            <label for="endDate">Fecha fin</label><br>
            <input type="date" id="endDate" name="endDate" value="<?= htmlspecialchars($endDate); ?>"><br>
        	<?= !empty($errors['endDate']) ? "<p class='error'>{$errors['endDate']}</p>" : '' ?>
        
            <label for="endTime">Hora fin</label><br>
            <input type="time" id="endTime" name="endTime" value="<?= htmlspecialchars($endTime); ?>"><br>
        	<?= !empty($errors['endTime']) ? "<p class='error'>{$errors['endTime']}</p>" : '' ?>
        
            <label for="description">Descripción</label><br>
            <textarea id="description" name="description"><?= htmlspecialchars($description); ?>"</textarea><br>
        	<?= !empty($errors['description']) ? "<p class='error'>{$errors['description']}</p>" : '' ?>
        
            <label for="categoria">Categoría</label><br>
            <input type="text" id="categoria" name="categoria" value="<?= htmlspecialchars($categoria); ?>"><br><br>
        
            <input type="submit" value="Crear Evento">
        </form>
      
</body>
</html>
<?php

    }
    
    public function mostrarEventos($events) {
      
        // Verificar si hay eventos
        if (!empty($events)) {
            echo "<div><h3>Eventos:</h3>";
            echo "<table border='1' class=\"event-table\"> ";
            echo "<thead>";
            echo "<tr>"; 
            echo "<th>Título</th>";
            echo "<th>Fecha de Inicio</th>";
            echo "<th>Hora de Inicio</th>";
            echo "<th>Fecha de Fin</th>";
            echo "<th>Hora de Fin</th>";
            echo "<th>Descripción</th>";
            echo "<th>Categoria</th>";
            echo "<th>Acciones</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            
            foreach ($events as $event) {
                echo "<tr>";
                echo "<td class=\"no-w\">" . htmlspecialchars($event['title']) . "</td>";
                echo "<td class=\"no-w\">" . htmlspecialchars($event['startDate']) . "</td>";
                echo "<td class=\"no-w\">" . htmlspecialchars($event['startTime']) . "</td>";
                echo "<td class=\"no-w\">" . htmlspecialchars($event['endDate']) . "</td>";
                echo "<td class=\"no-w\">" . htmlspecialchars($event['endTime']) . "</td>";
                echo "<td >" . htmlspecialchars($event['description']) . "</td>";
                echo "<td>" . (!empty($event['categoria']) ? htmlspecialchars($event['categoria']) : "Sin categoría") . "</td>";
                echo "<td class=\"no-w\">";
                
                // Botón para editar
                echo "<a href='?Mantenimiento/updateOne/{$event['id']}'><button> Editar </button></a>";
                
                // Botón para eliminar
                echo "<a href='?Mantenimiento/deleteOne/" . $event['id'] . "'><button> Eliminar </button></a>";
                
                echo "</td>";
                echo "</tr>";
            }
            
            echo "</tbody>";
            echo "</table>";
            echo "</div>";
        } else {
            echo "<p>No hay eventos disponibles.</p>";
        }
        
        echo "</div>  </div></body>";
    }
    
    public function updateOne($params) {
        
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
 <body> <div class="contenedor">
        <div class="menu-nav">
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
                        <li><a href="?Bolsa/show"> Bolsa </a></li>
                        <li><a href="?Calendar/show"> Calendario </a></li>
                        <li><a href=""> Mantenimiento </a></li>
                    </ul>
                </nav>
            </header>
  </div>
        ';
        
        // Formulario para crear evento
        echo '<div class="flex">
                    
        <form action="" method="POST">
            <label for="title">Título</label><br>
            <input type="text" id="title" name="title" value="'.$params[0]["title"].'"><br><br>
                    
            <label for="startDate">Fecha inicio</label><br>
            <input type="date" id="startDate" name="startDate" value="'.$params[0]["startDate"].'"><br><br>
                    
            <label for="startTime">Hora inicio</label><br>
            <input type="time" id="startTime" name="startTime" value="'.$params[0]["startTime"].'"><br><br>
                    
            <label for="endDate">Fecha fin</label><br>
            <input type="date" id="endDate" name="endDate" value="'.$params[0]["endDate"].'"><br><br>
                    
            <label for="endTime">Hora fin</label><br>
            <input type="time" id="endTime" name="endTime" value="'.$params[0]["endTime"].'"><br><br>
                    
            <label for="description"> Descripción </label><br>
            <textarea id="description" name="description"> '.$params[0]["description"].' </textarea><br><br>
                    
            <label for="categoria">Categoría</label><br>
            <input type="text" id="categoria" name="categoria" value="'.$params[0]["categoria"].'"><br><br>
                    
            <input type="submit" value="Crear Evento">
        </form>
                    
        </body>
    </html>';
    }
}

