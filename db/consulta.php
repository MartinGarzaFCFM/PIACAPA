<?php 
//////////////////
	//include_once '../db.php';
    include_once __DIR__ . '/../db.php';

	class consulta extends DB{

		function getNames(int $id){
			$query = $this->connect()->query('SELECT * FROM usuario WHERE id = '. $id);

			return $query;
		}
		/*
        No sirvió :(
        function obtenerProductos() {
            $query = $this->connect()->prepare('SELECT ID_PRO, PRO_NOMBRE, PRO_DESCRIPCION, PRO_PRECIOTOTAL FROM PRODUCTO');
            $query->execute();
            $productos = $query->fetchAll(PDO::FETCH_ASSOC);
        
            return $productos;
        }
        */
        function registro($usuario, $contrasena, $correo, $avatar, $Nombre, $nacimiento, $sexo, $rol,$Privacidad) {
            $sexoDB = ''; // Valor predeterminado vacío
            if ($sexo == 'Masculino') {
                $sexoDB = 'Masculino';
            } elseif ($sexo == 'Femenino') {
                $sexoDB = 'Femenino';
            }
          
          
          
            if ($rol == 'Cliente') {
                $rol = 1;
            } elseif ($rol == 'Vendedor') {
                $rol = 2;
            }


             
    

            $query = $this->connect()->prepare('CALL InsertarUsuarioPrivacidad(?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $query->execute([$usuario, $contrasena, $correo, $Nombre, $nacimiento, $sexoDB, $rol, $avatar,$Privacidad]);
            return $query;
        }

       
    

        function modificar($usuario, $contrasena, $correo, $nacimiento, $Nombre) {
            session_start();
        
            $query = $this->connect()->prepare('CALL ActualizarUsuario(?, ?, ?, ?, ?, ?)');
            
            $id = $_SESSION['usuario']['id'];
            
            $query->execute([$id, $usuario, $contrasena, $correo, $Nombre, $nacimiento]);
            
            return $query;
        }
        
        function eliminarUsuario() {
            session_start();
            $query = $this->connect()->prepare('CALL EliminarUsuario(?)');
            
            $id = $_SESSION['usuario']['id'];
            
            $query->execute([$id]);
            
            return $query;
        }
        
        
        function VerificarCredenciales($usuario, $password)
        {
            try {
                $pdo = $this->connect();
                $stmt = $pdo->prepare("CALL VerificarCredenciales(?, ?)");
                $stmt->bindParam(1, $usuario, PDO::PARAM_STR);
                $stmt->bindParam(2, $password, PDO::PARAM_STR);
                $stmt->execute();
                $usuarioDB = $stmt->fetch(PDO::FETCH_ASSOC);
        
                if ($usuarioDB) {
                    return $usuarioDB;
                } else {
                    return false;
                }
            } catch (PDOException $e) {
                
                echo "Error: " . $e->getMessage();
                return false;
            }
        }
      
       /* function verificarCorreoYUsuarioExistentes($correo, $usuario) {
            $query = $this->connect()->prepare('CALL VerificarCorreoYUsuarioExistentes(?, ?)');
            $query->execute([$correo, $usuario]);
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return $result;
        }*/
   
        function getCorreoExistente($correo) {
            $query = $this->connect()->prepare('SELECT correo FROM usuario WHERE correo = ?');
            $query->execute([$correo]);
            return $query->fetch();
        }
        
        function getUsuarioExistente($usuario) {
            $query = $this->connect()->prepare('SELECT usuario FROM usuario WHERE usuario = ?');
            $query->execute([$usuario]);
            return $query->fetch();
        }
        
       /* function getCorreoExistenteR($correo, $user_id) {
            $query = $this->connect()->prepare('SELECT correo FROM usuario WHERE correo = ? AND id != ?');
            $user_id = $_SESSION['usuario']['id'];
            $query->execute([$correo, $user_id]);
            return $query->fetch();
        }
        
        function getUsuarioExistenteR($usuario, $user_id) {
            $query = $this->connect()->prepare('SELECT usuario FROM usuario WHERE usuario = ? AND id != ?');
            $user_id = $_SESSION['usuario']['id'];
            $query->execute([$usuario, $user_id]);
            return $query->fetch();
        }*/

/*DELIMITER //
CREATE PROCEDURE VerificarCredencialesV(IN p_usuario VARCHAR(255), IN p_password VARCHAR(255))
BEGIN
    DECLARE pattern VARCHAR(255);
    SET pattern = '^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@#$%^&+=!])(?=.{8,})';
    
    IF p_password REGEXP pattern THEN
        SELECT 'Contraseña válida' AS mensaje;
    ELSE
        SELECT 'La contraseña no cumple con los requisitos' AS mensaje;
    END IF;
END //
DELIMITER ;*/

//CATEGORIA

function insertarCategoria($nombreCategoria, $descripcionCategoria) {
   
    $query = $this->connect()->prepare('CALL InsertarCategoria(?, ?, ?)');
    $user_id = $_SESSION['usuario']['id'];
    $query->execute([$nombreCategoria, $descripcionCategoria,  $user_id]);
    return $query;
}



/*
public function obtenerCategorias() {
    $query = $this->connect()->prepare('SELECT CAT_NOMBRE FROM CATEGORIAS');
    $query->execute();
    $categorias = $query->fetchAll(PDO::FETCH_COLUMN, 0); // Obtiene los nombres de las categorías
    return $categorias;
}*/
/*
public function obtenerCategorias() {
    $query = $this->connect()->prepare('SELECT * FROM Vista_Cat_egorias');
    $query->execute();
    $categorias = $query->fetchAll(PDO::FETCH_COLUMN, 0); // Obtiene los nombres de las categorías
    return $categorias;
}*/

public function obtenerCategorias() {
    $query = $this->connect()->prepare('SELECT * FROM Vista_Cat_egorias');
    $query->execute();
    $categorias = $query->fetchAll(PDO::FETCH_ASSOC); // Obtiene todas las columnas de cada fila
    return $categorias;
}
public function obtenerCategoriasVendedor() {
    $query = $this->connect()->prepare('SELECT * FROM VistaCategorias');
    $query->execute();
    $categorias = $query->fetchAll(PDO::FETCH_COLUMN, 0); // Usar el índice 0
    return $categorias;
}



public function obtenerProductosPorCategoriaVista($categoriaId) {
    $query = $this->connect()->prepare('
        SELECT *
        FROM Vista_Productos_Categoria
        WHERE CAT_ID = :categoriaId
    ');
    $query->bindParam(':categoriaId', $categoriaId, PDO::PARAM_INT);
    $query->execute();
    $productos = $query->fetchAll(PDO::FETCH_ASSOC);
    return $productos;
}


//PRODUCTOS
  
function registrarProducto($tipo, $nombreProducto, $descripcionProducto, $precioProducto, $cantidadProducto, $categoriaProducto, $videoBase64, $imagen_base64) {

    $query = $this->connect()->prepare('CALL InsertarProducto(?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $user_id = $_SESSION['usuario']['id'];
    $query->execute([$tipo, $nombreProducto, $descripcionProducto, $precioProducto, $cantidadProducto, $categoriaProducto, $videoBase64, $imagen_base64, $user_id]);
    return $query;
}





//function obtenerProductos() {
   // $query = $this->connect()->prepare('CALL FiltrarProducto()');
   // $query->execute();
    
   // $productos = $query->fetchAll(PDO::FETCH_ASSOC);
   // return $productos;
//}


function obtenerProductos() {
    $query = $this->connect()->prepare('SELECT * FROM VistaFiltrarProductooo');
    $query->execute();
    
    $productos = $query->fetchAll(PDO::FETCH_ASSOC);
    return $productos;
}



function aprobarProductoCotizado($idProducto) {
    try {
        $user_id = $_SESSION['usuario']['id'];

        $query = $this->connect()->prepare('CALL AprobarProductoCotizado(?)');
        $query->bindParam(1, $idProducto, PDO::PARAM_INT);
        $query->execute();

        return ['success' => true, 'message' => 'Producto cotizado aprobado con éxito'];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Error al aprobar el producto cotizado: ' . $e->getMessage()];
    }
}

public function EliminarProductoCotizado($idCoti) {
    try {
        $db = $this->connect();

        $query = $db->prepare('CALL EliminarProductoCotizado(?)');
        $query->bindParam(1, $idCoti, PDO::PARAM_INT);
        $query->execute();

        return ['success' => true, 'message' => 'Producto cotizado eliminado con éxito'];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Error al eliminar el producto cotizado: ' . $e->getMessage()];
    }
}


function obtenerProductoPorID($productoID) {
    $query = $this->connect()->prepare('CALL FiltrarProductoComprarrVendedorr(?)');
    $query->bindParam(1, $productoID, PDO::PARAM_INT);
    $query->execute();
    
    $producto = $query->fetch(PDO::FETCH_ASSOC);
    return $producto;
}








/*
function registrarProductoCotizable($tipo, $nombreProducto, $descripcionProducto, $precioProducto, $cantidadProducto, $categoriaProducto, $videoBase64, $imagen_base64, $materialProducto, $medidasProducto, $caducidadProducto) {
    // Asegúrate de manejar la sesión de manera adecuada
    // (iniciar sesión antes de llamar a esta función)

    $query = $this->connect()->prepare('CALL InsertarProductoCotizable(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $user_id = $_SESSION['usuario']['id'];
    $query->execute([$tipo, $nombreProducto, $descripcionProducto, $precioProducto, $cantidadProducto, $categoriaProducto, $videoBase64, $imagen_base64, $materialProducto, $medidasProducto, $caducidadProducto, $user_id]);
    return $query;

}*/
function registrarProductoCotizable($tipo, $nombreProducto, $descripcionProducto, $precioProducto, $cantidadProducto, $categoriaProducto, $videoBase64, $imagen_base64, $materialProducto, $medidasProducto) {
 

    
    $query = $this->connect()->prepare('CALL InsertarProductoCotizable(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');

    
    $user_id = $_SESSION['usuario']['id'];

    $query->execute([$tipo, $nombreProducto, $descripcionProducto, $precioProducto, $cantidadProducto, $categoriaProducto, $videoBase64, $imagen_base64, $materialProducto, $medidasProducto, $user_id]);

    return $query;
}




// LISTA



function registrarLista($nombreLista, $descripcionLista, $privacidadLista) {
    session_start();
   $user_id = $_SESSION['usuario']['id'];

    $query = $this->connect()->prepare('CALL InsertarLista(?, ?, ?, ?)');
   
    $query->execute([$nombreLista, $descripcionLista, $privacidadLista, $user_id]);
    return $query;
}
/* Estas funciones muestran las listas pero muestra listas sin autenticar el id del usuario que esta en el sistema
public function obtenerInformacionLista($ID_LISTA) {
    $query = $this->connect()->prepare('SELECT * FROM VistaInformacionLista WHERE ID_LISTA = ?');
    $query->bindParam(1, $ID_LISTA, PDO::PARAM_INT);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}



public function obtenerNombresListas() {
    $query = $this->connect()->prepare('SELECT ID_LISTA, LIST_NOMBRE FROM VistaInformacionLista');
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

*/


public function obtenerInformacionLista($ID_LISTA, $ID_USUARIO) {
    
    $query = $this->connect()->prepare('SELECT * FROM VistaInformacionLista WHERE ID_LISTA = ? AND LIST_CREADOR = ?');
    $user_id = $_SESSION['usuario']['id'];
    $query->bindParam(1, $ID_LISTA, PDO::PARAM_INT);
    $query->bindParam(2, $ID_USUARIO, PDO::PARAM_INT);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}

public function obtenerNombresListas($ID_USUARIO) {
    $query = $this->connect()->prepare('SELECT ID_LISTA, LIST_NOMBRE FROM VistaInformacionLista WHERE LIST_CREADOR = ?');
    $user_id = $_SESSION['usuario']['id'];
    $query->bindParam(1, $ID_USUARIO, PDO::PARAM_INT);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}
public function obtenerInformacionProducto($ID_PRO, $ID_USUARIO) {
    $query = $this->connect()->prepare('SELECT * FROM VistaInformacionProductooo WHERE ID_PRO = ? AND PRO_ID_USUARIO = ?');
    $query->bindParam(1, $ID_PRO, PDO::PARAM_INT);
    $query->bindParam(2, $ID_USUARIO, PDO::PARAM_INT);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}

public function obtenerNombresProductos($ID_USUARIO) {
    $query = $this->connect()->prepare('SELECT ID_PRO, PRO_NOMBRE FROM VistaInformacionProductooo WHERE PRO_ID_USUARIO = ?');

    $query->bindParam(1, $ID_USUARIO, PDO::PARAM_INT);

    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

public function obtenerInformacionCat($CAT_ID, $ID_USUARIO) {
    $query = $this->connect()->prepare('SELECT CAT_ID, CAT_NOMBRE, CAT_DESC FROM Vista_Categorias WHERE CAT_ID = ? AND CAT_CREADOR = ?');
    $query->bindParam(1, $CAT_ID, PDO::PARAM_INT);
    $query->bindParam(2, $ID_USUARIO, PDO::PARAM_INT);
    $query->execute();

    if ($query->rowCount() > 0) {
        return $query->fetch(PDO::FETCH_ASSOC);
    } else {
        return false;
    }
}


public function obtenerNombresCat($CAT_CREADOR) {
    try {
        $query = $this->connect()->prepare('SELECT CAT_ID, CAT_NOMBRE FROM Vista_Categorias WHERE CAT_CREADOR = ?');
        
        if ($query) {
            $query->bindParam(1, $CAT_CREADOR, PDO::PARAM_INT);
            $query->execute();

            if ($query) {
                return $query->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $errorInfo = $query->errorInfo();
                echo "Error al ejecutar la consulta: " . $errorInfo[2];
            }
        } else {
            $errorInfo = $this->connect()->errorInfo();
            echo "Error al preparar la consulta: " . $errorInfo[2];
        }
    } catch (PDOException $e) {
        echo "Error en la conexión: " . $e->getMessage();
    }

    return false;
}


/* esta sirve para agregar producto pero sin revisar cantidad ni precio total.
public function agregarAListaProducto($idLista, $idProducto, $user_id) {
    // Llama al procedimiento almacenado en lugar de realizar una consulta directa
    $query = $this->connect()->prepare('CALL AgregarProductoAListaa(?, ?, ?)');
    $user_id = $_SESSION['usuario']['id'];
    $query->bindParam(1, $idLista, PDO::PARAM_INT);
    $query->bindParam(2, $idProducto, PDO::PARAM_INT);
    $query->bindParam(3, $user_id, PDO::PARAM_INT);
    $query->execute();

    // Recupera el mensaje del procedimiento almacenado
    return $query->fetch(PDO::FETCH_ASSOC);
}*/




public function agregarAListaProducto($idLista, $idProducto, $user_id, $cantidad) {
    $query = $this->connect()->prepare('CALL AgregarProductoAListaCantidad(?, ?, ?, ?)');
    
    $user_id = $_SESSION['usuario']['id'];

    $query->bindParam(1, $idLista, PDO::PARAM_INT);
    $query->bindParam(2, $idProducto, PDO::PARAM_INT);
    $query->bindParam(3, $user_id, PDO::PARAM_INT);
    $query->bindParam(4, $cantidad, PDO::PARAM_INT);

    $query->execute();

    return $query->fetch(PDO::FETCH_ASSOC);
}



/*
public function cargarContenidoLista($ID_LISTA) {
    $user_id = $_SESSION['usuario']['id'];
    $query = $this->connect()->prepare('SELECT
        ID_LISTA,
        ID_PRO,
        ID_USUARIO_LISTA,
        PRO_NOMBRE,
        PRO_DESCRIPCION,
        PRO_PRECIOTOTAL,
        PRO_CANTIDAD,
        Imagen
    FROM
        VistaListaProductoss
    WHERE
        ID_LISTA = ? AND ID_USUARIO_LISTA = ?');
    $query->bindParam(1, $ID_LISTA, PDO::PARAM_INT);
    $query->bindParam(2, $user_id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}*/
public function cargarContenidoLista($ID_LISTA) {
    $user_id = $_SESSION['usuario']['id'];
    $query = $this->connect()->prepare('SELECT
        ID_LISTA,
        ID_PRO,
        ID_USUARIO_LISTA,
        PRO_NOMBRE,
        PRO_DESCRIPCION,
        PRO_PRECIOTOTAL,
        PRO_CANTIDAD,
        LISTA_PRO_CANTIDAD,
        PRO_PRECIO_TOTAL_CALCULADO,
        Imagen
    FROM
        VistaListaProductoss
    WHERE
        ID_LISTA = ? AND ID_USUARIO_LISTA = ?');
    $query->bindParam(1, $ID_LISTA, PDO::PARAM_INT);
    $query->bindParam(2, $user_id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}
public function cargarContenidoProd($ID_PRO) {
    $user_id = $_SESSION['usuario']['id'];
    $query = $this->connect()->prepare('SELECT
    ID_PRO,
    PRO_NOMBRE,
    PRO_DESCRIPCION,
    PRO_TIPO,
    PRO_PRECIOTOTAL,
    PRO_CANTIDAD,
    PRO_CATEGORIA
    FROM
    VistaProductosGestion
    WHERE
        ID_LISTA = ? AND ID_USUARIO_LISTA = ?');
   $query->bindParam(1, $ID_PRO, PDO::PARAM_INT);
   $query->bindParam(2, $user_id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}
public function cargarContenidoCat($idCategoria) {
    $user_id = $_SESSION['usuario']['id'];
    $query = $this->connect()->prepare('SELECT*
    FROM
    Vista_Categorias
    WHERE
    CAT_ID = ? AND CAT_CREADOR = ?');
   $query->bindParam(1, $CAT_ID, PDO::PARAM_INT);
   $query->bindParam(2, $user_id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

public function ModificarProducto($idProducto, $nombreProducto, $descripcionProducto, $tipoProducto, $cantidadProducto, $categoriaProducto, $precioProducto, $materialProducto, $medidasProducto) {
    try {
        $query = $this->connect()->prepare('CALL ModificarProductoo(?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $query->bindParam(1, $idProducto, PDO::PARAM_INT);
        $query->bindParam(2, $nombreProducto, PDO::PARAM_STR);
        $query->bindParam(3, $descripcionProducto, PDO::PARAM_STR);
        $query->bindParam(4, $tipoProducto, PDO::PARAM_INT);
        $query->bindParam(5, $cantidadProducto, PDO::PARAM_INT);
        $query->bindParam(6, $categoriaProducto, PDO::PARAM_STR);
        $query->bindParam(7, $precioProducto, PDO::PARAM_STR);
        $query->bindParam(8, $materialProducto, PDO::PARAM_STR);
        $query->bindParam(9, $medidasProducto, PDO::PARAM_STR);

        $query->execute();

        return ['success' => true, 'message' => 'Producto actualizado con éxito'];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Error al actualizar el producto: ' . $e->getMessage()];
    }
}
public function EditarCategoria($c_cat_id, $nuevo_nombre, $nueva_descripcion) {
    try {
        $query = $this->connect()->prepare('CALL EditarCategoria(?, ?, ?)');
        
        $query->bindParam(1, $c_cat_id, PDO::PARAM_INT);
        $query->bindParam(2, $nuevo_nombre, PDO::PARAM_STR);
        $query->bindParam(3, $nueva_descripcion, PDO::PARAM_STR);

        $query->execute();

        return ['success' => true, 'message' => 'Categoría actualizada con éxito'];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Error al actualizar la categoría: ' . $e->getMessage()];
    }
}

public function ModificarLista($idLista, $nombreLista, $descripcionLista, $tipoLista) {
    try {
        $query = $this->connect()->prepare('CALL ModificarLista(?, ?, ?, ?)');
        
        $user_id = $_SESSION['usuario']['id'];

        $query->bindParam(1, $idLista, PDO::PARAM_INT);
        $query->bindParam(2, $nombreLista, PDO::PARAM_STR);
        $query->bindParam(3, $descripcionLista, PDO::PARAM_STR);
        $query->bindParam(4, $tipoLista, PDO::PARAM_INT);

        $query->execute();

        return ['success' => true, 'message' => 'Lista actualizada con éxito'];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Error al actualizar la lista: ' . $e->getMessage()];
    }
}

public function EliminarProducto($idProducto) {
    try {
        $query = $this->connect()->prepare('CALL EliminarProducto(?)');
        $query->bindParam(1, $idProducto, PDO::PARAM_INT);
        $query->execute();

        return ['success' => true, 'message' => 'Producto eliminado con éxito'];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Error al eliminar el producto: ' . $e->getMessage()];
    }
}

public function EliminarCategoria($idCategoria) {
    try {
        $query = $this->connect()->prepare('CALL EliminarCategoria(?)');
        $query->bindParam(1, $idCategoria, PDO::PARAM_INT);
        $query->execute();

        return ['success' => true, 'message' => 'Categoría eliminada con éxito'];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Error al eliminar la categoría: ' . $e->getMessage()];
    }
}


public function EliminarLista($idLista) {
    try {
        $query = $this->connect()->prepare('CALL EliminarLista(?)');

        $query->bindParam(1, $idLista, PDO::PARAM_INT);

        $query->execute();

        return ['success' => true, 'message' => 'Lista eliminada con éxito'];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Error al eliminar la lista: ' . $e->getMessage()];
    }
}

public function eliminarProductoDeLista($idLista, $idProducto, $idUsuario) {
    try {
        $query = $this->connect()->prepare('CALL EliminarProductoDeLista(?, ?, ?)');

        $query->bindParam(1, $idLista, PDO::PARAM_INT);
        $query->bindParam(2, $idProducto, PDO::PARAM_INT);
        $query->bindParam(3, $idUsuario, PDO::PARAM_INT);

        $query->execute();

        return ['success' => true, 'mensaje' => 'Producto eliminado de la lista con éxito'];
    } catch (PDOException $e) {
        return ['success' => false, 'mensaje' => 'Error al eliminar el producto de la lista: ' . $e->getMessage()];
    }
}

public function ProductosPendientesAprobacion() {
    $query = $this->connect()->prepare('SELECT * FROM ProductosPendientesAprobacion');
   
  
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}


//-- -------------------------------------------------------------------------------------------------lina  16-11-2023


public function insertarConversacion($usuario1, $usuario2, $producto_id) {
    // Verifica si ya existe una conversación para estos usuarios y producto
    $id_conversacion_existente = $this->obtenerConversacionExistente($usuario1, $usuario2, $producto_id);

    if ($id_conversacion_existente) {
        // Si ya existe, devuelve el ID existente en lugar de crear uno nuevo
        return $id_conversacion_existente;
    }

    // Si no existe, crea una nueva conversación
    $query = $this->connect()->prepare('CALL InsertarConversacion(?, ?, ?)');

    // Vincular los parámetros
    $query->bindParam(1, $usuario1, PDO::PARAM_INT);
    $query->bindParam(2, $usuario2, PDO::PARAM_INT);
    $query->bindParam(3, $producto_id, PDO::PARAM_INT);

    // Ejecutar la consulta
    $query->execute();

    // Recupera el ID de la conversación recién creada
    $resultado = $query->fetch(PDO::FETCH_ASSOC);

    // Devuelve el ID de la conversación
    $id_conversacion = $resultado['id_conversacion'];
    

    // Almacena el ID en la sesión para futuras verificaciones
    $_SESSION['id_conversacion'] = $id_conversacion;

    return $id_conversacion;
}



// Función para verificar si ya existe una conversación para estos usuarios y producto
public function obtenerConversacionExistente($usuario1, $usuario2, $producto_id) {
    // Utiliza la vista en lugar de la tabla directamente
    $query = $this->connect()->prepare('SELECT id_conversacion FROM vista_conversacion_existente WHERE usuario1 = ? AND usuario2 = ? AND producto_id = ?');
    $query->bindParam(1, $usuario1, PDO::PARAM_INT);
    $query->bindParam(2, $usuario2, PDO::PARAM_INT);
    $query->bindParam(3, $producto_id, PDO::PARAM_INT);
    $query->execute();

    $resultado = $query->fetch(PDO::FETCH_ASSOC);

    return $resultado ? $resultado['id_conversacion'] : null;
}












public function obtenerMensajes($id_conversacion) {
    try {
        //$_SESSION['id_conversacion'] = $conversacion_id;
    $query = $this->connect()->prepare('SELECT * FROM VistaMensajesConversacion WHERE conversacion_id = :conversacion_id ORDER BY MSJ_FECHA');
    $query->bindParam(':conversacion_id', $id_conversacion, PDO::PARAM_INT);
    $query->execute();
    $mensajes = $query->fetchAll(PDO::FETCH_ASSOC);
    return $mensajes;
} catch (PDOException $e) {
    echo 'Error en la consulta: ' . $e->getMessage();
}
}






public function enviarMensaje($mensajeTexto, $remitente, $destinatario, $conversacion_id, $producto_id) {
    // Obtener el ID de usuario de la sesión (remitente)
    //$conversacion_id

    // Verificar que la conversación existe y obtener datos del remitente y destinatario
    //$query = $this->connect()->prepare('SELECT remitente, destinatario FROM VistaParaVerUsuYconversacion WHERE id_conversacion = :conversacion_id');
    //$query->bindParam(':conversacion_id', $conversacion_id, PDO::PARAM_INT);
    //$query->execute();
   // $conversacionInfo = $query->fetch(PDO::FETCH_ASSOC);

    //if (!$conversacionInfo) {
        // La conversación no existe
     //   return false;
    //}

    //$remitente = $conversacionInfo['remitente'];
   // $destinatario = $conversacionInfo['destinatario'];

    // Insertar el mensaje
    $query = $this->connect()->prepare('CALL sp_insertar_mensaje(:mensaje, :remitente, :destinatario, :conversacion_id,  :producto_id)');
    $query->bindParam(':mensaje', $mensajeTexto, PDO::PARAM_STR);
    $query->bindParam(':remitente', $remitente, PDO::PARAM_INT);
    $query->bindParam(':destinatario', $destinatario, PDO::PARAM_INT);
    $query->bindParam(':conversacion_id', $conversacion_id, PDO::PARAM_INT);
    $query->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);

    return $query->execute();
}






/*
public function vista_conversaciones_info($id_conversacion) {
    try {
        $query = $this->connect()->prepare('SELECT * FROM vista_conversaciones_info WHERE id_conversacion = :id_conversacion ORDER BY MSJ_FECHA');
        $query->bindParam(':id_conversacion', $id_conversacion, PDO::PARAM_INT);
        $query->execute();
        $mensajes = $query->fetchAll(PDO::FETCH_ASSOC);
        return $mensajes;
    } catch (PDOException $e) {
        // Manejar el error de manera adecuada, puedes loggearlo, enviar un correo electrónico, etc.
        echo 'Error en la consulta: ' . $e->getMessage();
        return false; // Opcionalmente, podrías lanzar una excepción aquí si prefieres.
    }
}*/

/*
public function obtenerMensajesVENDEDOR($id_conversacion) {
    try {
        $query = $this->connect()->prepare('
            SELECT 
                m.MSJ_ID,
                m.MSJ_MENSAJE,
                m.MSJ_REMITENTE,
                m.MSJ_DESTINATARIO,
                m.MSJ_FECHA,
                m.MSJ_LEIDO,
                m.conversacion_id,
                c.usuario1,
                u1.Nombre as RemitenteNombre,
                c.usuario2,
                u2.Nombre as DestinatarioNombre
            FROM MENSAJE m
            JOIN CONVERSACION c ON m.conversacion_id = c.id_conversacion
            JOIN usuario u1 ON m.MSJ_REMITENTE = u1.id
            JOIN usuario u2 ON m.MSJ_DESTINATARIO = u2.id
            WHERE c.id_conversacion = :conversacion_id
            ORDER BY m.MSJ_FECHA
        ');

        $query->bindParam(':conversacion_id', $id_conversacion, PDO::PARAM_INT);
        $query->execute();
        $mensajes = $query->fetchAll(PDO::FETCH_ASSOC);
        return $mensajes;
    } catch (PDOException $e) {
        echo 'Error en la consulta: ' . $e->getMessage();
    }
}*/
// En la clase consulta


/*
public function obtenerConversaciones() {
    try {
        // Utiliza la vista en lugar de la tabla directamente
        $query = $this->connect()->prepare('SELECT * FROM vista_conversaciones_info');
        $query->execute();

        $conversaciones = $query->fetchAll(PDO::FETCH_ASSOC);

        return $conversaciones;
    } catch (PDOException $e) {
        // Maneja los errores de la consulta PDO
        echo 'Error en la consulta: ' . $e->getMessage();
        return []; // Devuelve un array vacío en caso de error
    }
}*/
public function obtenerConversaciones($user_id) {
    try {
        // Utiliza la vista en lugar de la tabla directamente
        $query = $this->connect()->prepare('SELECT * FROM vista_conversaciones_info WHERE usuario2 = ?');
        $query->bindParam(1, $user_id, PDO::PARAM_INT);
        $query->execute();

        $conversaciones = $query->fetchAll(PDO::FETCH_ASSOC);

        return $conversaciones;
    } catch (PDOException $e) {
        // Maneja los errores de la consulta PDO
        echo 'Error en la consulta: ' . $e->getMessage();
        return []; // Devuelve un array vacío en caso de error
    }
}

/*
public function ObtenerInformacionProductoCotizado($producto_id) {
    $query = $this->connect()->prepare('CALL ObtenerInformacionProductoCotizado(?)');
    $query->bindParam(1, $producto_id, PDO::PARAM_INT);
    $query->execute();

    // Obtén todos los conjuntos de resultados
    $resultados = array();

    do {
        $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
        if ($resultado) {
            $resultados[] = $resultado;
        }
    } while ($query->nextRowset());

    // Devuelve todos los conjuntos de resultados
    return $resultados;
}*/

public function ObtenerInformacionProductoCotizado($producto_id) {
    $query = $this->connect()->prepare('CALL ObtenerInformacionProductoCotizadoCHAT(?)');
    $query->bindParam(1, $producto_id, PDO::PARAM_INT);
    $query->execute();

    // Obtén todos los conjuntos de resultados
    $resultados = array();

    do {
        $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
        if ($resultado) {
            $resultados[] = $resultado;
        }
    } while ($query->nextRowset());

    // Devuelve todos los conjuntos de resultados
    return $resultados;
}


function RegistrarAltaCotizacion($producto_id, $vendedor_id, $cliente_id, $precio_unitario, $material, $medidas, $cantidad) {
    $query = $this->connect()->prepare('CALL AltaCotizacionCarrito(?, ?, ?, ?, ?, ?, ?)');
   
     // Parámetros para el procedimiento almacenado
     $query->bindParam(1, $vendedor_id, PDO::PARAM_INT);
     $query->bindParam(2, $cliente_id, PDO::PARAM_INT);
     $query->bindParam(3, $producto_id, PDO::PARAM_INT);
     $query->bindParam(4, $precio_unitario, PDO::PARAM_STR);
     $query->bindParam(5, $material, PDO::PARAM_STR);
     $query->bindParam(6, $medidas, PDO::PARAM_STR);
     $query->bindParam(7, $cantidad, PDO::PARAM_STR);
    $query->execute();

    // Obtén todos los conjuntos de resultados
   
    return $query;
}

function AgregarProductoAlCarrito($producto_id, $usuario_id, $cantidad) {
    $query = $this->connect()->prepare('CALL Agregar_ProductoNormal_Carrito(?, ?, ?)');
    
    $query->bindParam(1, $producto_id, PDO::PARAM_INT);
    $query->bindParam(2, $usuario_id, PDO::PARAM_INT);
    $query->bindParam(3, $cantidad, PDO::PARAM_INT);

    // Ejecutar la consulta y verificar el resultado
    $success = $query->execute();

    if ($success) {
        // La consulta se ejecutó con éxito, puedes hacer más operaciones si es necesario
        $message = "Producto agregado al carrito con éxitooo";
    } else {
        // Hubo un error al ejecutar la consulta, puedes manejarlo según tus necesidades
        $message = "Error al agregar el producto al carritooo";
    }

    // Devolver un mensaje indicando el resultad
    return $message;
}



public function ObtenerInformacionCarritoUsuarioProducto($user_id) {
    $query = $this->connect()->prepare('CALL vista_carrito_usuario_producto(:user_id)');
    $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $query->execute();

    // Obtén todos los conjuntos de resultados
    $resultados = array();

    do {
        $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
        if ($resultado) {
            $resultados[] = $resultado;
        }
    } while ($query->nextRowset());

    // Si solo esperas un conjunto de resultados (una vista)
    // puedes devolver directamente el primer conjunto de resultados
    return isset($resultados[0]) ? $resultados[0] : null;
}





public function EliminarProductoDelCarrito($carrito_id) {
    $query = $this->connect()->prepare('CALL EliminarProductoDelCarrito(:carrito_id)');
    $query->bindParam(':carrito_id', $carrito_id, PDO::PARAM_INT);
    $query->execute();

    // Puedes manejar la respuesta o el error según tus necesidades
    // Por ejemplo, podrías retornar true en caso de éxito y false en caso de error
    return $query->rowCount() > 0; // Retorna true si se eliminó al menos una fila
}

public function ObtenerInformacionCarritoUsuarioProductoCotizado($user_id) {
    $query = $this->connect()->prepare('CALL vista_carrito_usuario_producto_cotizado(:user_id)');
    $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $query->execute();

    // Obtén todos los conjuntos de resultados
    $resultados = array();

    do {
        $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
        if ($resultado) {
            $resultados[] = $resultado;
        }
    } while ($query->nextRowset());

    // Si solo esperas un conjunto de resultados (una vista)
    // puedes devolver directamente el primer conjunto de resultados
    return isset($resultados[0]) ? $resultados[0] : null;
}


// nuevo 

// ////////////////////////////////////////////////////////////////////////////////////////////////////////////////


public function GestionarCotizacionesVencidas($cotizacion_id) {
    $query = $this->connect()->prepare('CALL GestionarCotizacionesVencidas(:cotizacion_id)');
    $query->bindParam(':cotizacion_id', $cotizacion_id, PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT, 255);
    $query->execute();

     // Obtén el valor del parámetro de salida
     $query->closeCursor(); // Es importante cerrar el cursor antes de obtener el valor de salida
     $outputQuery = $this->connect()->query("SELECT :cotizacion_id AS cotizacion_id");
     $cotizacion_id = $outputQuery->fetch(PDO::FETCH_COLUMN);

    // Puedes manejar la respuesta o el error según tus necesidades
    // Por ejemplo, podrías retornar true en caso de éxito y false en caso de error
    return $query->rowCount() > 0; // Retorna true si se ejecutó el procedimiento exitosamente
}


public function vista_para_eliminar_el_cotizado($user_id) {
    $query = $this->connect()->prepare('CALL vista_para_eliminar_el_cotizado(:user_id)');
    $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $query->execute();

    // Obtén todos los conjuntos de resultados
    $resultados = array();

    do {
        $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
        if ($resultado) {
            $resultados[] = $resultado;
        }
    } while ($query->nextRowset());

    // Si solo esperas un conjunto de resultados (una vista)
    // puedes devolver directamente el primer conjunto de resultados
    return isset($resultados[0]) ? $resultados[0] : null;
}


// ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

public function buscarProductos($busqueda) {
    $query = $this->connect()->prepare("CALL BuscarProductos(?)");
    $query->bindParam(1, $busqueda, PDO::PARAM_STR);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}




public function obtenerListasPorUsuario($usuario_id) {
    try {
        $conn = $this->connect();
        $stmt = $conn->prepare("CALL ObtenerListasPorUsuario(:usuario_id)");
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        $listas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $listas;
    } catch (PDOException $e) {
        // Manejar errores de base de datos según sea necesario
        echo "Error al obtener las listas: " . $e->getMessage();
        return [];
    }
}
public function obtenerProductosVendedor($usuario_id) {
    try {
        $conn = $this->connect();
        $stmt = $conn->prepare("CALL ObtenerProductosVendedor(:usuario_id)");
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $productos;
    } catch (PDOException $e) {
        echo "Error al obtener los productos del vendedor: " . $e->getMessage();
        return [];
    }
}
public function obtenerProductosAprobados() {
    try {
        $conn = $this->connect();
        $stmt = $conn->prepare("CALL ObtenerProductosAdimin()");
        $stmt->execute();
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $productos;
    } catch (PDOException $e) {
        echo "Error al obtener los productos aprobados: " . $e->getMessage();
        return [];
    }
}





public function InsertarCompra($id_user) {
    $conn = $this->connect();
    $stmt = $conn->prepare('CALL insert_compra(:id_user)');
    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->execute();

    // Puedes manejar la respuesta o el error según tus necesidades
    // Por ejemplo, podrías retornar true en caso de éxito y false en caso de error
    return $stmt->rowCount() > 0; // Retorna true si se ejecutó el procedimiento exitosamente
}

 /*
public function ConsultarCompras($fechaInicio = null, $fechaFin, $categoria = null, $id_usuario) {
    try {
        $conn = $this->connect();

        $stmt = $conn->prepare('CALL ConsultarCompras(:id_usuario, :categoria, :fechaInicio, :fechaFin)');
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->bindParam(':categoria', $categoria, PDO::PARAM_STR);
        $stmt->bindParam(':fechaInicio', $fechaInicio, PDO::PARAM_STR);
        $stmt->bindParam(':fechaFin', $fechaFin, PDO::PARAM_STR);
        $stmt->execute();

        // Retorna los resultados como un array asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Manejo de errores
        throw $e;
    }
}*/





public function ConsultarCompras($fecha_inicio, $fecha_fin, $categoria, $id_usuario) {
    try {
        $pdo = $this->connect();
        $query = $pdo->prepare("CALL ConsultarCompras(?, ?, ?, ?)");

        $query->bindParam(1, $fecha_inicio, PDO::PARAM_STR);
        $query->bindParam(2, $fecha_fin, PDO::PARAM_STR);
        $query->bindParam(3, $categoria, PDO::PARAM_STR);
        $query->bindParam(4, $id_usuario, PDO::PARAM_INT);

        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        // Cerrar la conexión y la declaración preparada
        $query = null;
        $pdo = null;

        return $results;
    } catch (PDOException $e) {
        // Loguear el error en lugar de imprimirlo directamente
        error_log("Error en ConsultarCompras: " . $e->getMessage());
        return false; // O manejar de otra manera según tus necesidades
    }
}

public function ConsultarComprasVendedor($fecha_inicio, $fecha_fin, $categoria, $id_usuario) {
    try {
        // Establecer conexión a la base de datos
        $pdo = $this->connect();

        // Preparar la llamada al procedimiento almacenado
        $query = $pdo->prepare("CALL ConsultarComprasVendedor(?, ?, ?, ?)");

        // Vincular parámetros
        $query->bindParam(1, $fecha_inicio, PDO::PARAM_STR);
        $query->bindParam(2, $fecha_fin, PDO::PARAM_STR);
        $query->bindParam(3, $categoria, PDO::PARAM_STR);
        $query->bindParam(4, $id_usuario, PDO::PARAM_INT);

        // Ejecutar la consulta
        $query->execute();

        // Obtener los resultados como un array asociativo
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        // Cerrar la conexión y la declaración preparada
        $query = null;
        $pdo = null;

        // Devolver los resultados
        return $results;
    } catch (PDOException $e) {
        // En caso de error, loguear el error y devolver false
        error_log("Error en ConsultarComprasVendedor: " . $e->getMessage());
        return false; // O manejar de otra manera según tus necesidades
    }
}

public function ConsultarProductosVendedor($categoria, $id_usuario) {
    try {
        // Establecer conexión a la base de datos
        $pdo = $this->connect();

        // Preparar la llamada al procedimiento almacenado
        $query = $pdo->prepare("CALL ConsultarProductosVendedor(?, ?)");

        // Vincular parámetros
        $query->bindParam(1, $categoria, PDO::PARAM_STR);
        $query->bindParam(2, $id_usuario, PDO::PARAM_INT);

        // Ejecutar la consulta
        $query->execute();

        // Obtener los resultados como un array asociativo
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        // Cerrar la conexión y la declaración preparada
        $query = null;
        $pdo = null;

        // Devolver los resultados
        return $results;
    } catch (PDOException $e) {
        // En caso de error, loguear el error y devolver false
        error_log("Error en ConsultarProductosVendedor: " . $e->getMessage());
        return false; // O manejar de otra manera según tus necesidades
    }
}






}
?>