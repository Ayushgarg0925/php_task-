<?php 
include '../common/conn1.php';


session_start();

$login = function () use ($conn) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // 🔐 Default Admin Credentials
    $default_email = "a@gmail.com";
    $ppp1 = '12345';

    // ✅ Check Default Admin First
    if ($email === $default_email && $password === $ppp1) {
        $_SESSION['a'] = "Admin";
        $_SESSION['id'] = 0;

        echo json_encode(array(
            'success' => true,
            'statuscode' => 200,
            'message' => 'Admin Successfully logged in.'
        ));
        exit();
    }

    // 🔎 Normal Database Login
    $sql1 ="SELECT id,email_id,PASSWORD,name FROM user_master where email_id='".$email."'";
    $result = $conn -> Execute($sql1);
    if ($conn -> num_rows($result)>0) {
        while ($state = $conn -> fetch_array($result)) {
            $pwd=$state['PASSWORD'];
            $id=$state['id'];
            $a=$state['name'];
        }

        if(password_verify($password, $pwd)){
            $_SESSION['a']=$a;
            $_SESSION['id']=$id;

            echo json_encode(array(
                'success' => true,
                'statuscode' => 200,
                'message' => 'Successfully logged in.'
            ));
            exit();
        } else {
            echo json_encode(array(
                'success' => false,
                'statuscode1' => 300,
                'message1' => 'Login failed.'
            ));
            exit();
        }
    } else {
        echo json_encode(array(
            'success' => false,
            'statuscode' => 150,
            'message' => 'This Email does not exist'
        ));
        exit();
    }
};


$rows_count = function () use ($conn){
    $sql = "CALL total_count();";
    $result = $conn -> Execute($sql);
    if ($conn -> num_rows($result)>0) {
        while ($usercount = $conn -> fetch_array($result)) {
            // print_r($usercount);die;
                echo json_encode(array('success' => true, 'statuscode' => 200, 'result' => $usercount));

        }}
};

if (isset($_POST['type']) && $_POST['type']=='login'){
    $login();
}
elseif (isset($_POST['type']) && $_POST['type']=='rows_count'){
    $rows_count();
}

?>



