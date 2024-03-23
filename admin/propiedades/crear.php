<?php


require '../../includes/config/database.php';

$db = conectarDB();

// arreglo con mensajes de errores

$errores = [];





//  Ejecutar el codigo luego de que el usuario llena y envia el formulario

if ($_SERVER["REQUEST_METHOD"] === 'POST') {

    // echo "<pre>";
    // var_dump($_POST);      Mostrar los datos que esta almacenando el POST
    // echo "</pre>";

    //  Guardando datos del post
    $titulo = $_POST['titulo'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $habitaciones = $_POST['habitaciones'];
    $wc = $_POST['wc'];
    $estacionamiento = $_POST['estacionamiento'];
    $vendedores_id = $_POST['vendedores_id'];


    if (!$titulo) {
        $errores[] = "Debes añadir un titulo";
    }

    if (!$precio) {
        $errores[] = "Debes añadir un precio";
    }

    // Validando que el usuario ponga una descripcion apropiada de la casa 
    if (strlen($descripcion) <= 50) {
        $errores[] = "Debes añadir una descripcion y esta debe tener almenos 50 caracteres";
    }
    if (!$habitaciones) {
        $errores[] = "El numero de habitaciones es obligatorio";
    }
    if (!$wc) {
        $errores[] = "El numero de baños es obligatorio";
    }
    if (!$estacionamiento) {
        $errores[] = "El numero de lugares de estacionamiento es obligatorio";
    }

    echo "<pre>";
    var_dump($errores);
    echo "</pre>";

    exit;


    // Insertar en la base de datos
    $query = " INSERT INTO propiedades(titulo,precio,descripcion,habitaciones,wc,estacionamiento,vendedores_id)
    VALUES ('$titulo','$precio','$descripcion','$habitaciones','$wc','$estacionamiento','$vendedores_id')";


    // probando que el $query guarde los datos para ingresarlos a la base de datos
    // echo $query;

    $resultado = mysqli_query($db, $query);

    if ($resultado) {
        echo "Insertado correctamente";
    }
}

require '../../includes/funciones.php';

incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Crear</h1>

    <a href="../index.php" class="boton boton-verde">volver</a>

    <!-- POST para enviar datos de forma segura por lo general se utiliza para enviar datos a un servidor -->
    <!-- GET para obtener los datos y mostrarlos en la url  por lo general se usa para obtener datos de un servidor -->
    <form class="formulario" method="POST" action="/bienesraices/admin/propiedades/crear.php">



        <fieldset>
            <legend>Informacion general</legend>

            <label for="titulo">Titulo:</label>
            <input type="text" id="titulo" name="titulo" placeholder="Titulo propiedad">

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" placeholder="Precio propiedad">

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" accept="image/jpeg, image/png">


            <label for="descripcion">Descripcion:</label>
            <textarea id="descripcion" name="descripcion"></textarea>
        </fieldset>

        <fieldset>
            <legend>Informacion Propiedad</legend>

            <label for="habitaciones">Habitaciones:</label>
            <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" min="1" max="9">


            <label for="wc">Baños:</label>
            <input type="number" id="wc" name="wc" placeholder="Ej: 3" min="1" max="9">

            <label for="estacionamiento">Estacionamiento:</label>
            <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej: 3" min="1" max="9">
        </fieldset>


        <fieldset>
            <legend>Vendedor</legend>

            <select name="vendedores_id">
                <option value="1">Oscar</option>
                <option value="2">Karen</option>
            </select>
        </fieldset>

        <input type="submit" class="boton boton-verde" value="Crear Propiedad">

    </form>

</main>

<?php
incluirTemplate('footer')
?>