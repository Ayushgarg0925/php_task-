<?php

if ($i_quantity==0) {
    echo json_encode(array('success' => false, 'statuscode' => 303, 'message' => 'insert item quantity '));
    exit();
}
$sqlCheckItem = "SELECT s_no, item_name, item_price FROM item_master where s_no =" .$i_id;
// print_r($sqlCheckItem);
$resultItem = $conn->execute($sqlCheckItem);

if ($conn->num_rows($resultItem) > 0) {
    $existingClientData = $conn->fetch_assoc($resultItem);

    if ($i_price != $existingClientData['item_price'] || $i_name != $existingClientData['item_name']) {
        echo json_encode(array('success' => false, 'statuscode' => 303, 'message' => 'item data does not match the existing data.'));
        exit();
    }
} 
else {
    echo json_encode(array('success' => false, 'statuscode' => 303, 'message' => 'item not found'));
    exit();
}
?>