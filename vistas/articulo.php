<?php
include_once ('../CRUD/CRUDArticulo.php');
include_once ('../CRUD/CRUDCuenta.php');
include_once ('../CRUD/CRUDComentario.php');

function readComentariosArticulo($idArticulo) {
    $con = conexionBD();
    $res = False;
    $query = "SELECT * FROM comentarios WHERE idArticulo = $idArticulo and idRespuesta is NULL";
    $result = $con->query($query);
    ?>
    <ul>
        <?php
        while ($comentario = mysqli_fetch_array($result)) {
            ?><li><?php echo $comentario['texto']; ?></li><?php
            ?><?php
            hiloComentario($comentario);
        }
        ?>
    </ul>
    <?php
    desconectar($con);
    return $res;
}

function hiloComentario($respuesta) {
    $con = conexionBD();
    $idComentario = $respuesta['idComentario'];
    ?>
    <ul>
        <?php
        $query = "SELECT * FROM comentarios WHERE idRespuesta = $idComentario";
        $result = $con->query($query);
        while ($respuesta = mysqli_fetch_array($result)) {
            ?><li><?php echo $respuesta['texto']; ?></li><?php
            hiloComentario($respuesta);
        }
        ?>
    </ul><?php
}
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content=="IE=edge"/>
        <meta name="google" value="notranslate"/>
        <link href="css.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" type="text/css" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
        <title>Article</title>

    </head>
    <body>
        <header>
            <h1>MoarNews</h1>
            <h2>The Digital Newspaper</h2>
        </header>

        <?php
        include_once 'nav.php';
        ?>
       
        <aside>
            <!-- Anuncios -->
        </aside>
        <?php
        $articulo = readArticulo(1);
        $autor = readCuenta($articulo['idCuenta']);
// print_r($autor);
        ?>
        <article>
            <div class="imagenArticulo">
                <a href="<?php
                if ($articulo['imagen'] != NULL) {
                    echo 'imagenes/' . $articulo['imagen'];
                }
                ?>"><?php
                       if ($articulo['imagen'] != NULL) {
                           echo $articulo['imagen'];
                       }
                ?></a>
            </div>
            <div class="tituloArticulo">
                <h2><?php echo $articulo['titulo']; ?></h2>
            </div>
            <div class="descripcionArticulo">
<?php echo $articulo['descripcion']; ?>
            </div>
            <div class="fechaArticulo">
<?php echo $articulo['fecha']; ?>
            </div>
            <div class="autorArticulo">
<?php echo $autor['nombre']; ?>
            </div>
            <div class="comentariosArticulo">
<?php readComentariosArticulo($articulo['idArticulo']); ?>
            </div>
        </article>
        <footer>

        </footer>
    </body>
</html>
