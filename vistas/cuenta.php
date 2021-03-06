<!DOCTYPE html>
<?php
include_once("../CRUD/CRUDCuenta.php");
include_once("../CRUD/CRUDComentario.php");
include_once("../CRUD/CRUDArticulo.php");

function mediaPuntuacion($sumaTotal, $numComentarios) {
    return $res = $sumaTotal / $numComentarios;
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content=="IE=edge"/>
        <meta name="google" value="notranslate"/>
        <link href="css.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" type="text/css" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
        <title>Account</title>
    </head>
    <body>
        <?php
        session_start();

        if (!isset($_SESSION['cuentaID'])) {
            header('Location:inicioSesion.php');
        }
        if (isset($_SESSION['cuentaID'])) {
            $nombreUsuario = $_SESSION['nombreUsuario'];
            $idUsuario = $_SESSION['cuentaID'];
        }
        $datosPersonales = readCuenta($idUsuario);
        ?>
        <!--datos usuario--> 
        <?php
        include_once 'nav.php';
        ?>

        <h1 class="centrar"> Profile of <?php echo $nombreUsuario; ?></h1>
        <table cellpadding="10" border="1">
            <tr>
                <th>Name</th>
                <th>User</th>
                <th>Email</th>
                <th>Format</th>
                <th>Type</th>
                <th>Visual disability</th>
                <th>Preferences</th>

            </tr>
            <tr>
                <td align='center'><?php echo $datosPersonales['nombre']; ?></td>
                <td align='center'><?php echo $datosPersonales['usuario']; ?></td>
                <td align='center'><?php echo $datosPersonales['email']; ?></td>
                <td align='center'><?php echo $datosPersonales['formato']; ?></td>
                <td align='center'><?php echo $datosPersonales['tipo']; ?></td>
                <td align='center'><?php echo $datosPersonales['Dv']; ?></td>
                <?php $gustos = explode(",", $datosPersonales['gustos']);?>
                <td align='center'>
                    <ul type="square">
                        <?php
                        for ($index = 0; $index < count($gustos); $index++) {
                            echo "<li> $gustos[$index] </li>";
                        }
                        ?>
                    </ul>
                </td>
            </tr> 
        </table>
        <section>
            <?php
            if ($_SESSION['tipo'] === 'usuario') {
                $sumaTotal = 0;
                $comentarios = readAllComentariosFromID($idUsuario);
                ?>
                <table cellpadding="10" border="1">
                    <tr>Comments: </tr>
                    <!--                comprobar si es mayor que 0, osea que no este vacio-->

                    <?php if ($comentarios) { ?>
                        <?php foreach ($comentarios as $comentario) { ?> 

                            <tr>
                                <th>identifier: </th>     
                                <th>text: </th>     
                                <th>puntuation: </th>     
                            </tr>
                            <tr>
                                <td align='center'><?php echo $comentario['idComentario']; ?></td>
                                <td align='center'><?php echo $comentario['texto']; ?></td>
                                <td align='center'><?php echo $comentario['puntuacion']; ?></td>


                                <!--falta hacer la media de la puntuación-->
                            </tr>

                            <?php $sumaTotal = $comentario['puntuacion'] + $sumaTotal;
                            ?>

                        <?php } $media = mediaPuntuacion($sumaTotal, count($comentarios)); ?>

                        <table cellpadding="10" border="1">
                            <tr>
                                <th>Average score comments: </th>     
                            </tr>
                            <tr>
                                <td align='center'><?php echo $media; ?></td>
                            </tr>
                        </table>

                        <!--                si autor, listado de articulos-->
                        <?php
                    } else {
                        echo "<h3 class='centrar'>There is no comments associated to this account</h3>";
                    }
                    if($datosPersonales['formato'] === "silver" || $datosPersonales['formato'] === "gold"){
                        ?>
                        <h3>Minigames</h3>
                        <form action="juego.php" method="POST">
                            <input type="hidden" name="tipo" value="<?php echo $datosPersonales['formato'];?>">
                            <input type="hidden" name="nombre" value="<?php echo $datosPersonales['nombre'];?>">
                            <input type="submit" name="jugar3raya" value="Play three in a row!">
                        </form>
                        <form action="juego2.php" method="POST">
                            <input type="hidden" name="tipo" value="<?php echo $datosPersonales['formato'];?>">
                            <input type="hidden" name="nombre" value="<?php echo $datosPersonales['nombre'];?>">
                            <input type="submit" name="jugarahorcado" value="Play hangman!">
                        </form>
                        <?php
                    }
                    if($datosPersonales['formato'] === "bronze" || $datosPersonales['formato'] === "silver" || $datosPersonales['formato'] === "gold"){
                        ?>
                        <h3>Newspaper archive</h3>
                        <form action="hemeroteca.php" method="POST">
                            <input type="hidden" name="tipo" value="<?php echo $datosPersonales['formato'];?>">
                            <input type="hidden" name="nombre" value="<?php echo $datosPersonales['nombre'];?>">
                            <input type="hidden" name="gustos" value="<?php echo $datosPersonales['gustos'];?>">
                            <input type="hidden" name="Dv" value="<?php echo $datosPersonales['Dv'];?>">
                            <input type="submit" name="hemeroteca" value="Access to the newspaper archive">
                        </form>
                        <?php
                    }
                    ?>
                    <?php
                } else if ($_SESSION['tipo'] === 'autor') {
                    $articulos = readArticulosFromID($idUsuario);
                    ?>
                    <table cellpadding="10" border="1">
                        <tr>Articles: </tr>
                        <?php
                        if ($articulos) {
                            foreach ($articulos as $articulo) {
                                ?> 

                                <tr>
                                    <td align='center'><?php echo $articulo['idArticulo']; ?></td>
                                    <td align='center'><?php echo $articulo['fecha']; ?></td>
                                    <td align='center'><?php echo $articulo['titulo']; ?></td>
                                    <td align='center'><?php echo $articulo['descripcion']; ?></td>
                                    <td align='center'><?php echo $articulo['imagen']; ?></td>
                                    <td align='center'><?php echo $articulo['audio']; ?></td>
                                </tr>

                                <?php
                            }
                        }
                        ?>
                    </table>
                    <div class="button alt small"><a href="gestionArticulo.php">Article management</a></div>
                <?php } else if ($_SESSION['tipo'] === 'administrador') { ?>

                    <div class="button alt small"><a href="gestionSeccion.php">Section management</a></div>

                    <div class="button alt small"><a href="gestionPortada.php">Front page management</a></div>

                    <div class="button alt small"><a href="gestionAnuncios.php">Advertisement management</a></div>
                    
                    <form action="registroAutor.php" method="POST">
                        <input type="hidden" name="tipo" value="<?php echo $datosPersonales['tipo'];?>">
                        <input type="submit" name="registrarAutor" value="Register author">
                    </form>


                <?php }
                ?>
                <div class="button alt small"><a href="modificarCuenta.php">Modify account</a></div>
        </section>
        
        
        <footer id="footer">
            <div class="inner">
                <h2>Get In Touch</h2>
                <ul class="actions">
                    <li><i class="icon fa-phone"></i> <a href="#">(034)954 34 92 00</a></li>
                    <li><span class="icon fa-envelope"></span> <a href="#">moarnewspa@gmail.com</a></li>
                    <li><span class="icon fa-map-marker"></span> Ctra. de Utrera, 1, 41013 Sevilla </li>
                </ul>
            </div>
            <div class="copyright">
                &copy; Newspaper. MoarNews <a href="https://www.upo.es/portal/impe/web/portada/index.html">MoarNews</a>. Images <a href="../imagenes/logo.jpeg" alt="logo">MoarNews</a>.

            </div>
        </footer>
    </body>


</html>

