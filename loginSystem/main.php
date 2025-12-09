<?php 
include '../common/conn1.php';


session_start();

$login = function () use ($conn) {
    $email=$password="";    
    $email= $_POST["email"];
    $password= $_POST["password"];

    $sql1 ="SELECT id,email_id,PASSWORD,name FROM user_master where email_id='".$email."'";
    $result = $conn -> Execute($sql1);

    if ($conn -> num_rows($result)>0) {
        while ($state = $conn -> fetch_array($result)) {
            $pwd=$state['PASSWORD'];
            $id=$state['id'];
            $a=$state['name'];
            
            // print_r($state);die;
        };  
        $verify = password_verify($password, $pwd); 
            if($verify){
                echo json_encode(array('success' => true, 'statuscode' => 200, 'message' => 'Successfully logged in.'));
                $_SESSION['a']=$a;
                $_SESSION['id']=$id;
                exit();
            }
            else{
                echo json_encode(array('success' => false, 'statuscode1' => 300, 'message1' => 'logged in fail.'));
                exit();
            }
    }
    else{
        echo json_encode(array('success' => true, 'statuscode' => 150, 'message' => 'This Email is not Exist'));
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



