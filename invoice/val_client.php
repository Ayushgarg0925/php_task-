<?php

 if (empty($client_hid_id_invoice) || empty($client_name_invoice)) {
    echo json_encode(array('success' => false, 'statuscode' => 303, 'message' => 'Fill all client details.'));
    exit();
}

$sqlCheckClient = "SELECT id, name, email, mobile_no FROM client_master 
                WHERE id = '$client_hid_id_invoice'";
$result = $conn->execute($sqlCheckClient);

if ($conn->num_rows($result) > 0) {
    $existingClientData = $conn->fetch_assoc($result);

    if ($client_name_invoice != $existingClientData['name']) {
        echo json_encode(array('success' => false, 'statuscode' => 303, 'message' => 'Client data does not match the existing data.'));
        exit();
    }
} 
else {
    echo json_encode(array('success' => false, 'statuscode' => 303, 'message' => 'Client not found'));
    exit();
}
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

?>