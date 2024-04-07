<?php



// base de datos
require '../../includes/config/database.php';

$db = conectarDB();

// Consultar la base de vendedores

$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($db, $consulta);



// Arreglo con mensajes de errores

$errores = [];

$titulo = '';
$precio = '';
$descripcion = '';
$habitaciones = '';
$wc = '';
$estacionamiento = '';
$vendedores_id = '';




//  Ejecutar el codigo luego de que el usuario llena y envia el formulario

if ($_SERVER["REQUEST_METHOD"] === 'POST') { //'SERVER' NOS TRAE INFORMACION MAS DETALLLADA DE LO QUE PASA EN EL SERVIDOR 

    // $numero = "1Hola";
    // $numero2 = 1;            pruebas de sanitizacion

    // $resultado = filter_var($numero, FILTER_SANITIZE_EMAIL);

    // var_dump($resultado);


    // exit;



    // echo "<pre>";
    // var_dump($_POST); // POST nos trae la info cuando enviamos una peticion de tipo POST  a nuestro formulario
    // echo "</pre>";


    // //comprobando subida de archivos
    // echo "<pre>";
    // var_dump($_FILES); // FILES nos permite ver el contenido de los archivos 
    // echo "</pre>";

    // exit;

    //  Guardando datos del post
    $titulo = mysqli_real_escape_string($db, $_POST['titulo']);
    $precio = mysqli_real_escape_string($db, $_POST['precio']);
    $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
    $habitaciones = mysqli_real_escape_string($db, $_POST['habitaciones']);
    $wc = mysqli_real_escape_string($db, $_POST['wc']);
    $estacionamiento = mysqli_real_escape_string($db, $_POST['estacionamiento']);
    $vendedores_id = mysqli_real_escape_string($db, $_POST['vendedores_id']);
    $creado = date('Y/m/d');

    // Asignando files hacia una variable

    // $imagen = $_FILES['imagen'];


    // var_dump($imagen['name']);


    // exit;


    if (!$titulo) {
        $errores[] = "!Debes añadir un titulo";
    }

    if (!$precio) {
        $errores[] = "!Debes añadir un precio";
    }

    // Validando que el usuario ponga una descripcion apropiada de la casa 
    if (strlen($descripcion) <= 50) {
        $errores[] = "!Debes añadir una descripcion y esta debe tener almenos 50 caracteres";
    }
    if (!$habitaciones) {
        $errores[] = "!El numero de habitaciones es obligatorio";
    }
    if (!$wc) {
        $errores[] = "!El numero de baños es obligatorio";
    }
    if (!$estacionamiento) {
        $errores[] = "!El numero de lugares de estacionamiento es obligatorio";
    }
    if (!$vendedores_id) {
        $errores[] = '!Elige un vendedor';
    }

    if (!$imagen['name']) {
        $errores[] = 'La Imagen es Obligatoria';
    }




    // echo "<pre>";
    // var_dump($errores);
    // echo "</pre>";

    // Revisar que el arreglo de errores este vacio para enviar los datos a la base 

    if (empty($errores)) {

        // Insertar en la base de datos
        $query = " INSERT INTO propiedades(titulo, precio, descripcion, habitaciones, wc, estacionamiento, creado, vendedores_id)
    VALUES ('$titulo','$precio','$descripcion','$habitaciones','$wc','$estacionamiento','$creado','$vendedores_id')";


        // probando que el $query guarde los datos para ingresarlos a la base de datos
        // echo $query;

        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            //Redireccionar a pagina de admin
            header('Location: /bienesraices/admin/index.php');
        }
    }
}

require '../../includes/funciones.php';

incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Crear</h1>

    <a href="../index.php" class="boton boton-verde">volver</a>




    <!-- // Mostrando errores o alertas al usuario -->
    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>



    <!-- POST para enviar datos de forma segura por lo general se utiliza para enviar datos a un servidor -->
    <!-- GET para obtener los datos y mostrarlos en la url  por lo general se usa para obtener datos de un servidor -->
    <form class="formulario" method="POST" action="/bienesraices/admin/propiedades/crear.php" enctype="multipart/form-data">



        <fieldset>
            <legend>Informacion general</legend>

            <label for="titulo">Titulo:</label>
            <input type="text" id="titulo" name="titulo" placeholder="Titulo propiedad" value="<?php echo $titulo; ?>">

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" placeholder="Precio propiedad" value="<?php echo $precio; ?>">

            <label for=" imagen">Imagen:</label>
            <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">


            <label for="descripcion">Descripcion:</label>
            <textarea id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>

        </fieldset>

        <fieldset>
            <legend>Informacion Propiedad</legend>

            <label for="habitaciones">Habitaciones:</label>
            <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" min="1" max="9" value="<?php echo $habitaciones; ?>">


            <label for="wc">Baños:</label>
            <input type="number" id="wc" name="wc" placeholder="Ej: 3" min="1" max="9" value="<?php echo $wc; ?>">

            <label for="estacionamiento">Estacionamiento:</label>
            <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej: 3" min="1" max="9" value="<?php echo $estacionamiento; ?>">
        </fieldset>


        <fieldset>
            <legend>Vendedor</legend>

            <select name="vendedores_id">
                <option value="">--Seleccione--</option>
                <?php while ($vendedor = mysqli_fetch_assoc($resultado)) : ?>
                    <option <?php echo $vendedores_id === $vendedor['id'] ? 'selected' : ''; ?> value="<?php echo $vendedor['id']; ?>"> <?php echo $vendedor['nombre'] . " " . $vendedor['apellido']; ?> </option>

                <?php endwhile; ?>
            </select>


        </fieldset>

        <input type="submit" class="boton boton-verde" value="Crear Propiedad">

    </form>

</main>

<?php
incluirTemplate('footer')
?>