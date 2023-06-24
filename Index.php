<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla</title>
</head>
<body>

<style>
        body {
            font-family: Arial;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 20px;
            padding: 20px;
            border radius: 45px;
        }

        h1 {
            text-align: center;
            margin-bottom: 35px;
            color: Orange; 
        }

        form {
            display: flex;
            margin-bottom: 20px;
        }

        input[type="text"] {
            flex: 1;
            padding: 8px;
            border: none;
            border-radius: 4px;
            margin-right: 10px;
            background-color: aqua;
            text-align: center;
        }

        button[type="submit"] {
            padding: 8px 16px;
            background-color: aqua;
            color: black;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: yellow;
            text-align: center;
        }

        th {
            background-color: red;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: green;
        }

        tr:hover {
            background-color: blue;
        }

        button:hover {
            background-color: red;
        }
    </style>
    
<?php
    // Abrir la conexión a la base de datos.
    $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
    $conexion = new PDO('mysql:host=localhost;dbname=Recuperacion_SU_NUMERO_CARNET', 'root', '', $pdo_options);
    
    // Ejecutar la consulta
    $select = $conexion->query("SELECT codigo, nombre, precio, existencia FROM producto");

    // Procesar el formulario cuando se envíe
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["accion"]) && $_POST["accion"] == "Crear") {
            $codigo = $_POST["codigo"];
            $nombre = $_POST["nombre"];
            $precio = $_POST["precio"];
            $existencia = $_POST["existencia"];
            
            // Insertar los datos en la base de datos
            $stmt = $conexion->prepare("INSERT INTO producto (codigo, nombre, precio, existencia) VALUES (?, ?, ?, ?)");
            $stmt->execute([$codigo, $nombre, $precio, $existencia]);
            
            header("Location: http://localhost/ExamenRecuperaci%C3%B3n/");
            exit();
        }
    }
?>


    <div class="container">
        <h1>Tabla Productos</h1>

        <?php if (isset($_POST["accion"]) && $_POST["accion"] == "Crear") { ?>
            <form method="POST">
                <input type="text" name="codigo" placeholder="Ingresa el código "/>
                <input type="text" name="nombre" placeholder="Ingresa el nombre"/>
                <input type="text" name="precio" placeholder="Ingresa el precio"/>
                <input type="text" name="existencia" placeholder="Ingresa la existencia"/>
                <button type="submit" name="accion" value="Crear">Crear</button>
            </form>

        <?php  } else { ?>
            <form method="POST">
                <input type="text" name="codigo" placeholder="Ingresa el código"/>
                <input type="text" name="nombre" placeholder="Ingresa el nombre"/>
                <input type="text" name="precio" placeholder="Ingresa el precio"/>
                <input type="text" name="existencia" placeholder="Ingresa la existencia"/>
                <input type="hidden" name="accion" value="Crear"/> 
                <button type="submit">Crear</button>
            </form>
        <?php  } ?>

        <table >
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Existencia</th>
                </tr>
            </thead>
            <tbody>
             <?php foreach($select->fetchAll() as $producto) { ?>
                   <tr>
                    <td> <?php echo $producto["codigo"] ?> </td>
                    <td> <?php echo $producto["nombre"] ?> </td>
                    <td> <?php echo $producto["precio"] ?> </td>
                    <td> <?php echo $producto["existencia"] ?> </td>
                   </tr>
             <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
