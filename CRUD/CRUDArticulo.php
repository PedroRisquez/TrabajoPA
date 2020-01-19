<?php

include_once "conexion.php";

//Devuelve True si ha creado o False si hay error
function createArticulo($articulo) {
    $con = conexionBD();
    $res = FALSE;
    $fecha = $articulo['texto'];
    $titulo = $articulo['titulo'];
    $descripcion = $articulo['descripcion'];
    $imagen = $articulo['imagen'];
    $audio = $articulo['audio'];
    $query = "INSERT INTO articulos (fecha, titulo, descripcion, imagen, audio) VALUES ('$fecha','$titulo','$descripcion','$imagen','$audio')";
    $result = $con->query($query);
    if ($result) {
        $res = TRUE;
    }
    desconectar($con);
    return $res;
}

//Devuelve False si no hay datos o un array con el datos
function readArticulo($idArticulo) {
    $con = conexionBD();
    $res = False;
    $query = "SELECT * FROM articulos WHERE idArticulo = $idArticulo";
    $result = $con->query($query);
    if ($result->num_rows !== 0) {
        $res = $result->fetch_assoc();
    }
    desconectar($con);
    return $res;
}

//Devuelve True si ha actualizado o False si hay error
function updateArticulo($articulo) {
    $con = conexionBD();
    $res = FALSE;
    $idArticulo = $articulo['idArticulo'];
    $fecha = $articulo['texto'];
    $titulo = $articulo['titulo'];
    $descripcion = $articulo['descripcion'];
    $imagen = $articulo['imagen'];
    $audio = $articulo['audio'];
    $query = "UPDATE articulos SET fecha = '$fecha', titulo = '$titulo', descripcion = '$descripcion', imagen = '$imagen', audio = '$audio' WHERE idArticulo = $idArticulo";
    $result = $con->query($query);
    if ($result) {
        $res = True;
    }
    desconectar($con);
    return $res;
}

//Devuelve True si se ha borrado o  False y hay error
function deleteArticulo($idArticulo) {
    $con = conexionBD();
    $res = FALSE;
    $query = "DELETE FROM articulos WHERE idArticulo = $idArticulo";
    $result = $con->query($query);
    if ($result) {
        $res = TRUE;
    }
    desconectar($con);
    return $res;
}

//Devuelve False si hay fallo/no hay datos o un array con los datos
function readAllArticulo() {
    $con = conexionBD();
    $res = FALSE;
    $query = "SELECT * FROM articulos";
    $result = $con->query($query);
    if ($result->num_rows !== 0) {
        $res = array();
        for ($i = 0; $i < $result->num_rows; $i++) {
            array_push($res, $result->fetch_assoc());
        }
    }

    desconectar($con);
    return $res;
}

function readArticulosFromID($idCuenta) {
    $con = conexionBD();
    $res = FALSE;
    $query = "SELECT * FROM articulos WHERE idCuenta=$idCuenta";
    $result = $con->query($query);
    if ($result->num_rows !== 0) {
        $res = array();
        for ($i = 0; $i < $result->num_rows; $i++) {
            array_push($res, $result->fetch_assoc());
        }
    }

    desconectar($con);
    return $res;
}

function asociarArticulo($idArticulo, $idSeccion) {
    $con = conexionBD();
    $res = FALSE;

    $query = "INSERT INTO articulossecciones (idSeccion, idArticulo) VALUES ($idSeccion,$idArticulo)";
    $result = $con->query($query);
    if ($result) {
        $res = TRUE;
    }
    desconectar($con);
    return $res;
}

function leerArticulosSeccion($idSeccion) {
    $con = conexionBD();
    $res = FALSE;
    $query = "SELECT * FROM articulossecciones WHERE idSeccion=$idSeccion";
    $result = $con->query($query);
    if ($result->num_rows !== 0) {
        $res = array();
        for ($i = 0; $i < $result->num_rows; $i++) {
            array_push($res, $result->fetch_assoc());
        }
    }

    desconectar($con);
    return $res;
}

function leerArticulosDadaSeccion($idSeccion) {
    $idArticulos = leerArticulosSeccion($idSeccion);
    $con = conexionBD();
    $res = FALSE;
    if($idArticulos){
        $res = array();
        foreach ($idArticulos as $id) {
        $idArticulo = $id['idArticulo'];
        $query = "SELECT * FROM articulos WHERE idArticulo=$idArticulo";
        $result = $con->query($query);
        if ($result->num_rows !== 0) {
            
            array_push($res, $result->fetch_assoc());
        }
    }
    }
    
    desconectar($con);
    return $res;
}

function borraSeccionDeArticulo($idArticulo) {
    $con = conexionBD();
    $res = FALSE;
    $query = "DELETE FROM articulossecciones WHERE idArticulo=$idArticulo";
    $result = $con->query($query);
    if ($result) {
        $res = TRUE;
    }
    desconectar($con);
    return $res;
}

//Devuelve False si hay fallo/no hay datos o un array con los datos
function readAllArticuloPorFecha() {
    $con = conexionBD();
    $res = FALSE;
    $query = "SELECT * FROM articulos ORDER BY fecha DESC";
    $result = $con->query($query);
    if ($result->num_rows !== 0) {
        $res = array();
        for ($i = 0; $i < $result->num_rows; $i++) {
            array_push($res, $result->fetch_assoc());
        }
    }

    desconectar($con);
    return $res;
}

function readComentariosArticuloPortada($idArticulo) {
    $con = conexionBD();
    $res = False;
    $query = "SELECT * FROM comentarios WHERE idArticulo = $idArticulo";
    $result = $con->query($query);
    if ($result->num_rows !== 0) {
        $res = array();
        for ($i = 0; $i < $result->num_rows; $i++) {
            array_push($res, $result->fetch_assoc());
        }
    }
    desconectar($con);
    return $res;
}
