<?php 
include '../common/conn1.php';
// get State ========================================================================================
$getState = function () use ($conn) {
    $sql = "SELECT id, name FROM states";
    $result = $conn -> Execute($sql);
    
    if ($conn -> num_rows($result)) {
        $output = "<option value='0'>-select-</option>";
        while ($state = $conn ->fetch_array($result)) {
            $sid = $state['id'];
            $name = $state['name'];
            $output .= "<option value='" . $sid . "'>" . $name . "</option>";
        }
        echo $output;
    }
};
// get cities ========================================================================================
$getCity = function () use ($conn) {
    $state_id = $_POST['id'];
    $sql = "SELECT id, name FROM cities where state_id = $state_id ";
    $result = $conn -> Execute($sql);
    if ($conn -> num_rows($result)) {
        $output = "<option value='0'>-select-</option>";
        while ($cities =$conn ->fetch_array($result)) {
            $cid = $cities['id'];
            $name = $cities['name'];
            $output .= "<option value='" . $cid . "'>" . $name . "</option>";
        }
        echo $output;
    }
};
$insert_client_data = function () use ($conn){
    $name=$email=$mobile_no=$address=$state=$cities="";
    $client_hid_inp=$_POST['client_hid_inp'];

    $name=$_POST['client_name'];
    $email=$_POST['client_email']; 
    $mobile_no=$_POST['client_mobile_no'];
    $address=$_POST['client_address']; 
    $state=$_POST['client_state'];
    $cities=$_POST['client_city']??0;

    if($client_hid_inp==""){
        if($name == "" or $email == "" or $mobile_no == "" or $address == "" or $state == "" or $cities == ""){
            $conn -> json_true(140, "all field required");
        }
        else{
            $sql_insert= "INSERT INTO client_master (name, email, mobile_no, address, state, cities) VALUES ('$name', '$email', '$mobile_no', '$address', '$state', '$cities')";
            $result = $conn -> Execute($sql_insert);    
            if($result){
                $conn -> json_true(150, "Data Add Successfully");
            }
            else{
                $conn -> json_true(300, "email already exist");
            }
        }
    }
    else{
        $sql_update="UPDATE client_master SET name='$name', email='$email', mobile_no='$mobile_no', address='$address', state='$state', cities='$cities' WHERE  id= $client_hid_inp";
        $result = $conn -> Execute($sql_update);
        if($result){
            $conn -> json_true(180, "Update data Successfully");
        }
        else{
            $conn -> json_true(300, "email already exist");
        }
    };    
} ;
$show_client_data = function () use ($conn){
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $pagination_client_page = $_POST['pagination_client_page'];

    $s_name = $conn -> test_input($_POST['s_name']);
    $s_email = $conn -> test_input($_POST['s_email']);
    $s_phoneno = $conn -> test_input($_POST['s_mobile_no']);
    $column_name=$_POST['column_name'];
    $sorting=$_POST['sorting'];
    $offset = ($page - 1) * $pagination_client_page;
    
    $sql_data="SELECT cm.id,cm.name,cm.email,cm.mobile_no,cm.address,s.name AS state,c.name AS cities FROM client_master cm 
    LEFT JOIN states s ON cm.State = s.id 
    LEFT JOIN cities c ON cm.cities = c.id
    where cm.name like '%$s_name%' and cm.email like '%$s_email%' and cm.mobile_no like '%$s_phoneno%'
    ORDER BY $column_name $sorting";

    $temp=$sql_data;

    $sql_data .=" LIMIT $offset, $pagination_client_page";
    
    $result= $conn -> Execute($sql_data);
    if($result){
        $output="";
        if($conn -> num_rows($result)>0){
            $serial = $offset + 1;
            while($data = $conn -> fetch_array($result)){
                $sid_d = $data['id'];            
                $output .= "
                <tr>
                    <td class='show_u_data1'>{$data["id"]}</td>
                    <td class='show_u_data1 td-no edit_btn_style' onclick='edit_client_data({$sid_d})'>{$data["name"]}</td>
                    <td class='show_u_data1 td-no'>{$data["mobile_no"]}</td>
                    <td class='show_u_data1 td-wrap' title='{$data["email"]}' maxlength='20'>{$data["email"]}</td>
                    <td class='show_u_data1 td-wrap' title='{$data["address"]}, \n{$data["cities"]}, {$data["state"]}'>{$data["address"]}, {$data["cities"]}, {$data["state"]}</td>
                    <td align='center'>
                        <button type='button' id='edit'  class='show_u_data1' onclick='edit_client_data({$sid_d})' style='border:none;background-color:transparent;' ><i class='fa-regular fa-pen-to-square'></i></button>
                    </td>
                    <td>
                        <button type='button'  id='delt'  class='show_u_data1' onclick='delete_client_data({$sid_d})' style='border:none;background-color:transparent;'><i class='fa-regular fa-trash-can' style='color:red;'></i></button>
                    </td>
                </tr>";
                $serial++;
            }
            $t_record_Query_Result = $conn -> Execute($temp);
            $totalRecords = $conn -> num_rows($t_record_Query_Result);
            $totalPages = ceil($totalRecords / $pagination_client_page);

            $pagination = '';
            for ($i = 1; $i <= $totalPages; $i++) {
                $isActive = ($i == $page) ? 'active' : '';
                $pagination .= "<button class='pagination-btn border $isActive' onclick='show_data($i)' style= color: #fff; padding: 5px 10px; margin: 2px; border: 1px solid #337ab7;'>$i</button>";
            }
            echo json_encode(array('table' => $output, 'pagination' => $pagination));
        }
        else {
            $output ="<h2>No Record Found</h2>";
            $pagination = "";
            echo json_encode(array('table' => $output, 'pagination' => $pagination));
        }
    }
    else {
        echo json_encode(array('error' => 'Query failed: '));
    }
    
};
$delete_client_data = function () use ($conn){
    $d_id = $_POST['id'];
    $d_sql="delete from client_master where id =". $d_id;
    $result = $conn -> Execute($d_sql);
    if ($result){
        $conn -> json_true(200, "delete data $d_id");
    }
    else{
        $conn -> json_true(250, "This client reference to invoice");
    };
};
$edit_client_data = function () use ($conn){
    $edit_id = $_POST['id'];
    $e_sql="select * from client_master where id =". $edit_id;
    $result = $conn -> Execute($e_sql);
    $a = $conn -> fetch_assoc($result);
    echo json_encode($a);
};


if(isset($_POST['type']) && $_POST['type']== 'state'){
    $getState();
}
elseif(isset($_POST['type']) && $_POST['type']== 'cities'){
    $getCity();
}
elseif(isset($_POST['type']) && $_POST['type']== 'insert_clientMaster'){
    $insert_client_data();
}
elseif(isset($_POST['type']) && $_POST['type']== 's_data'){
    $show_client_data();
}
elseif(isset($_POST['type']) && $_POST['type']== 'delete'){
    $delete_client_data();
}
elseif(isset($_POST['type']) && $_POST['type']== 'edit'){
    $edit_client_data();
}
?>