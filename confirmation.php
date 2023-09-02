<?php
/*En esta página se reciben las variables enviadas desde ePayco hacia el servidor.
Antes de realizar cualquier movimiento en base de datos se deben comprobar algunos valores
Es muy importante comprobar la firma enviada desde ePayco
Ingresar  el valor de p_cust_id_cliente lo encuentras en la configuración de tu cuenta ePayco
Ingresar  el valor de p_key lo encuentras en la configuración de tu cuenta ePayco
*/
$archivo_log = './registro_transacciones.txt';


$p_cust_id_cliente = '11736';
$p_key             = '491d6a0b6e992cf924edd8d3d088aff1';

$x_ref_payco      = $_REQUEST['x_ref_payco'];
$x_transaction_id = $_REQUEST['x_transaction_id'];
$x_amount         = $_REQUEST['x_amount'];
$x_currency_code  = $_REQUEST['x_currency_code'];
$x_signature      = $_REQUEST['x_signature'];



$signature = hash('sha256', $p_cust_id_cliente . '^' . $p_key . '^' . $x_ref_payco . '^' . $x_transaction_id . '^' . $x_amount . '^' . $x_currency_code);

// obtener invoice y valor en el sistema del comercio
$numOrder = '2531'; // Este valor es un ejemplo se debe reemplazar con el número de orden que tiene registrado en su sistema
$valueOrder = '10000';  // Este valor es un ejemplo se debe reemplazar con el valor esperado de acuerdo al número de orden del sistema del comercio

$x_response     = $_REQUEST['x_response'];
$x_motivo       = $_REQUEST['x_response_reason_text'];
$x_id_invoice   = $_REQUEST['x_id_invoice'];
$x_autorizacion = $_REQUEST['x_approval_code'];
// se valida que el número de orden y el valor coincidan con los valores recibidos
if ($x_id_invoice === $numOrder && $x_amount === $valueOrder) {
//Validamos la firma
if ($x_signature == $signature) {
    /*Si la firma esta bien podemos verificar los estado de la transacción*/
    $x_cod_response = $_REQUEST['x_cod_response'];
    switch ((int) $x_cod_response) {
        case 1:
            
            echo "transacción aceptada";
            break;
        case 2:
           
            echo "transacción rechazada";
            break;
        case 3:
        
            echo "transacción pendiente";
            break;
        case 4:
        
            echo "transacción fallida";
            break;
        }
    // Registro de datos en el archivo de registro
    $registro = "Transacción Exitosa - Ref Payco: $x_ref_payco, ID Transacción: $x_transaction_id, Monto: $x_amount, Respuesta: $x_response, Fecha y Hora: " . date('Y-m-d H:i:s') . "\n";

    ///Archivo de registro
    file_put_contents($archivo_log, $registro, FILE_APPEND);
} else {
    // La firma no es válida, registra un mensaje de error
    $error = "Firma no válida - Ref Payco: $x_ref_payco, ID Transacción: $x_transaction_id, Monto: $x_amount, Respuesta: $x_response, Fecha y Hora: " . date('Y-m-d H:i:s') . "\n";
    file_put_contents($archivo_log, $error, FILE_APPEND);
    die("Firma no válida");
}
} else {
// Número de orden o valor pagado no coinciden, registra un mensaje de error
$error = "Número de orden o valor pagado no coinciden - Ref Payco: $x_ref_payco, ID Transacción: $x_transaction_id, Monto: $x_amount, Respuesta: $x_response, Fecha y Hora: " . date('Y-m-d H:i:s') . "\n";

//Archivo de registro
file_put_contents($archivo_log, $error, FILE_APPEND);
die("Número de orden o valor pagado no coinciden");
}

