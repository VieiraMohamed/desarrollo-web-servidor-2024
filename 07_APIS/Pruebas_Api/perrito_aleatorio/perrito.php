<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
    ?>
    <title>Perros de Dog API</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        select, button {
            padding: 10px 20px;
            font-size: 16px;
        }
    </style>
</head>
<body>

<h1>Perros de Dog API</h1>

<!-- Formulario para seleccionar una raza -->
<form method="GET" action="">
    <label for="raza">Selecciona una raza:</label><br/>
    <select name="raza" id="razaSelect">
        <option value="" disabled selected>-- Selecciona una raza --</option>
        <?php
            $apiURL = "https://dog.ceo/api/breeds/list/all";
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $apiURL);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            
            // Ejecutar la solicitud y obtener el resultado
            $respuesta = curl_exec($curl);
            
            if (curl_errno($curl)) {
                echo "<p>Error: " . curl_error($curl) . "</p>";
            } else {
                // Decodificar la respuesta JSON
                $razasData = json_decode($respuesta, true);
                
                // Verificar si es un array y no una cadena de texto
                if (is_array($razasData['message'])) {
                    foreach ($razasData['message'] as $raza => $subRazas) {
                        // Mostrar la raza principal si no hay subrazas
                        if (empty($subRazas)) {
                            echo "<option value=\"$raza\">$raza</option>";
                        } else {
                            foreach ($subRazas as $sRaza => $imagen) {
                                echo "<option value=\"$raza-$sRaza\">$raza - $sRaza</option>";
                            }
                        }
                    }
                } else {
                    // Si la respuesta no es un array, mostrar un mensaje de error
                    echo "<p>Error en la respuesta de la API.</p>";
                }
            }
            
            curl_close($curl);
        ?>
    </select>
    <button type="submit">Mostrar Fotos</button>
</form>

<?php
// Procesar la selección de raza o mostrar fotos disponibles
if (!empty($_GET["raza"])) {
    $razaElegida = $_GET["raza"];
    
    // URL base para obtener imágenes de la raza elegida
    if (strpos($razaElegida, "-")) {
        list($categoria, $subRaza) = explode('-', $razaElegida);
        
        // URL de la API para obtener imágenes específicas de la sub-raza
        $apiURL = "https://dog.ceo/api/breed/{$categoria}/{$subRaza}/images";
    } else {
        // Si no hay sub-raza, seleccionamos la raza principal
        $categoria = $razaElegida;
        
        // URL de la API para obtener imágenes generales de la categoría
        $apiURL = "https://dog.ceo/api/breed/{$categoria}/images";
    }
    
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $apiURL);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $respuesta = curl_exec($curl);
    if (curl_errno($curl)) {
        echo "<p>Error: " . curl_error($curl) . "</p>";
    } else {
        // Decodificar la respuesta JSON
        $imagenesData = json_decode($respuesta, true);

        if ($imagenesData['status'] === 'success' && isset($imagenesData['message'])) {
            $fotosDisponibles = $imagenesData['message'];

            echo '<form method="GET" action="">';
            
            // Mostrar todas las fotos disponibles para esa raza/sub-raza
            echo '<label for="imagenElegida">Selecciona una foto:</label><br/>';
            echo '<select name="imagenElegida" id="imagenSelect">';
            foreach ($fotosDisponibles as $indice => $imagen) {
                // Mostrar la imagen con un miniatura y el índice
                echo "<option value=\"$imagen\">[$indice] <img src='$imagen' alt='Miniatura' style='width: 50px;'/></option>";
            }
            echo '</select>';
            
            echo '<button type="submit">Mostrar Foto</button>';
            echo '</form>';

            // Mostrar la imagen elegida si se selecciona
            if (!empty($_GET["imagenElegida"])) {
                $imagenElegida = $_GET["imagenElegida"];
                
                // Verificar si la imagen elegida existe en el array de fotos disponibles
                foreach ($fotosDisponibles as $indice => $img) {
                    if ($img === $imagenElegida) {
                        echo '<img src="' . $imagenElegida . '" style="width: 300px;" />';
                        break;
                    }
                }
            }
        } else {
            echo "<p>No hay fotos disponibles.</p>";
        }

        curl_close($curl);
    }
}
?>

<a href="perrito_aleatorio.php">FETCH</a>

</body>
</html>
