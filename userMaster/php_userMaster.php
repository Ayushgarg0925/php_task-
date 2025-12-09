<?php 
// include '../common/connection.php';
include '../common/conn1.php';
session_start();
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$insert_user_master = function () use ($conn) {
    $name=$email=$no=$pwd=$h_input="";

    $h_input=$_POST['h_input'];
    $name=test_input($_POST['user_name']);
    $email=test_input($_POST['email']);
    $no=test_input($_POST['mobile_no']);
    $pwd=$_POST['pwd'];
    $hid_pwd=$_POST['hid_pwd'];
    $s_pwd = password_hash($pwd, PASSWORD_DEFAULT);
    

    $duplicate= $conn -> Execute("select * from user_master where email_id='$email'");
      

    if ($h_input===""){
        if ($conn -> num_rows($duplicate)>0)
        {
            echo json_encode(array('success' => true, 'statuscode' => 150, 'message' => 'email already exist'));
        }
        elseif ($email == "")
        {
            echo json_encode(array('success' => true, 'statuscode' => 180, 'message' => 'email required'));
        }
        elseif ($pwd == "")
        {
            echo json_encode(array('success' => true, 'statuscode' => 180, 'message' => 'password are required'));
        }
        else{
            
             $sql = "INSERT INTO user_master (name,email_id,mobile_no,PASSWORD) VALUES('$name','$email','$no', '$s_pwd')"; 
            //  print_r($sql);die;
            $result = $conn -> Execute($sql);
            if ($result) {
                echo json_encode(array('success' => true, 'statuscode' => 200, 'message' => 'add successfully!!'));
            } 
        }
    } 
    else{     
        if ($email == "")
        {
            echo json_encode(array('success' => true, 'statuscode' => 180, 'message' => 'email required'));
        }
        elseif(!$pwd==""){
            $sql1 = "UPDATE `user_master` SET `name`='$name',`email_id`='$email', `mobile_no`='$no', `PASSWORD`='$s_pwd' WHERE  `id`=$h_input";
            $result = $conn -> Execute($sql1);
            if ($result) {
                echo json_encode(array('success' => true, 'statuscode' => 250, 'message' => 'update successfully!!'));
            }
        }
        else{
            $sql1 = "UPDATE `user_master` SET `name`='$name',`email_id`='$email', `mobile_no`='$no', `PASSWORD`='$hid_pwd' WHERE  `id`=$h_input";
        $result = $conn -> Execute($sql1);
        if ($result) {
            echo json_encode(array('success' => true, 'statuscode' => 250, 'message' => 'update successfully!!'));
        }
        }
    }
};

$show_user_list = function () use ($conn) {   
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $recordsPerPage = $_POST['recordsPerPage'];

    $s_name = $conn -> test_input ($_POST['s_name']);
    $s_email = $conn -> test_input( $_POST['s_email']);
    $s_phoneno = $conn -> test_input($_POST['s_phoneno']);
    $column_name=$_POST['column_name'];
    $sorting=$_POST['sorting'];

    $offset = ($page - 1) * $recordsPerPage;

    // $sql = "SELECT * FROM user_master";
    // if(!empty($fullName) || !empty($email) || !empty($mobileNumber)) {
    //     $sql .= " WHERE 1=1 ";
    // }
    // if (!empty($fullName)) {
    //     $sql .= " AND name LIKE '%$fullName%'";
    // }
    // if (!empty($email)) {
    //     $sql .= " AND email_id = '$email'";
    // }
    // if (!empty($mobileNumber)) {
    //     $sql .= " AND mobile_no = '$mobileNumber'";
    // }
    // $sql .= " LIMIT $offset, $recordsPerPage;";

     $sql = "select * from user_master where name like '%$s_name%' and email_id like '%$s_email%' and mobile_no like '%$s_phoneno%' ORDER BY $column_name $sorting ";
     $temp = $sql;
     $sql .=" LIMIT $offset, $recordsPerPage"; 
     $result = $conn -> Execute($sql);
    if ($result) {
        $output = " ";
        if ($conn -> num_rows($result) > 0) {
            $serial = $offset + 1;
            while ($row = $conn -> fetch_assoc($result)) {
                $sid_d = $row['id'];
                $output .= "
                <tr>
                    <td class='show_u_data'>{$row["id"]}</td>
                    <td class='show_u_data edit_btn_style' onclick='user_editrec({$sid_d})'>{$row["name"]}</td>
                    <td class='show_u_data td-wrap' title='{$row["email_id"]}'>{$row["email_id"]}</td>
                    <td class='show_u_data'>{$row["mobile_no"]}</td>
                    <td align='center'>
                        <button type='button' id='edit'  class='show_u_data' onclick='user_editrec({$sid_d})' style='border:none;background-color:transparent;' ><i class='fa-regular fa-pen-to-square'></i></button>
                    </td>
                    <td>
                        <button type='button'  id='delt'  class='show_u_data' onclick='user_deleterec({$sid_d})' style='border:none;background-color:transparent;'><i class='fa-regular fa-trash-can' style='color:red;'></i></button>
                    </td>
                </tr>";
                $serial++;
            }

            $totalrecordsqueryResult = $conn -> Execute($temp);
            $totalRecords = $conn -> num_rows($totalrecordsqueryResult);
            $totalPages = ceil($totalRecords / $recordsPerPage);


            $pagination = '';
            for ($i = 1; $i <= $totalPages; $i++) {
                $isActive = ($i == $page) ? 'active' : '';
                $pagination .= "<button class='border pagination-btn $isActive' onclick='show_user_master_data($i)' style= color: #fff; padding: 5px 10px; margin: 2px; border: 1px solid #337ab7;'>$i</button><br><br>";
            }
            echo json_encode(array('table' => $output, 'pagination' => $pagination));
        } else {
            // echo "<h2>No Record Found</h2>";
            $output="";
            $output="<tr><td colspan='6'><h2>No Record Found</h2></td></tr>";
            $pagination="";
        echo json_encode(array('table' => $output, 'pagination' => $pagination));
        }
    } else {
        echo json_encode(array('error' => 'Query failed: '));
    }
};

$delete_user_data =function ($Did) use ($conn){
    $sql2 = "delete from user_master where id = ".$Did;

    $storedId = $_SESSION['id'];

    if ($Did == $storedId) {
        echo json_encode(array('success' => true, 'statuscode' => 200, 'message' => 'Cannot delete user with this ID.'));
        exit();
    }

    $result2 = $conn -> Execute($sql2);
    if ($result2){
        echo json_encode(array('success' => true, 'statuscode' => 400, 'message' => 'Your data has been deleted'. $Did));
    };

};

$edit_user_data =function ($Edit_id) use ($conn){
    $sql ="select * from user_master where id=".$Edit_id;
    $result = $conn -> Execute($sql);
    $a = $conn -> fetch_assoc($result);
    echo json_encode($a);
};

// condition
if(isset($_POST['type']) && $_POST['type']== 'insert_userMaster'){
    $insert_user_master();
}
elseif(isset($_POST['type']) && $_POST['type']== 'show'){
    $show_user_list();
}
elseif(isset($_POST['type']) && $_POST['type']== 'delete'){
    $Did=$_POST['id'];
    $delete_user_data($Did);
}
elseif(isset($_POST['type']) && $_POST['type']== 'edit_userMaster_row'){
    $Edit_id=$_POST['id'];
    $edit_user_data($Edit_id);
}

?>