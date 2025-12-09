<?php 
include '../common/conn1.php';



$insert_item = function () use ($conn){
    $item_name=$item_description=$item_price="";
    $hidden_item_field=$_POST['hidden_item_field'];
    $hid_img=$_POST['hid_img'];
    $item_name=$_POST['item_name'];
    $item_description=$_POST['item_description'];
    $item_price=$_POST['item_price'];
    $up_file = $_FILES['file'];
    // print_r($up_file["name"]);die;
    $target_path = "";
    
    if (isset($_FILES['file'])) {     
        $file_name = $_FILES['file']['name'];
        $file_size = $_FILES['file']['size'];
        $file_tmp = $_FILES['file']['tmp_name'];
        $file_type = $_FILES['file']['type'];
        move_uploaded_file($file_tmp, "img/" . $file_name);
    };      

    

    $allowedFileTypes = array('jpg', 'jpeg', 'png', 'gif',"");
    $fileExtension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if (!in_array($fileExtension, $allowedFileTypes)) {
        echo json_encode(array('success' => false, 'statuscode' => 155, 'message' => 'Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.'));
        exit();
    }


    $maxFileSize = 2 * 1024 * 1024;

    if ($file_size > $maxFileSize) {
        echo json_encode(array('success' => false, 'statuscode' => 155, 'message' => 'File size exceeds the allowed limit 2mb.'));
        exit();
    }


    $show_path = $target_path . $file_name;
   
    if($hidden_item_field == ""){
        if($item_name == "" or $item_description == "" or $item_price == "" ){
            $conn -> json_true(140, "all field are required");
        }
        else{
            $sql_insert="INSERT INTO item_master (item_name, item_description, item_price, item_file) VALUES ('$item_name','$item_description','$item_price','$show_path')";
            $result=$conn -> Execute($sql_insert);
            if ($result){
                $conn -> json_true(150, "Data Add Successfully");
            }
            else{
                $conn -> json_true(155, "item already exist ");
            }
        }
    }
    else{
        if(!$up_file["name"] == ""){
            // print_r($up_file);die;
            $sql_insert="UPDATE item_master SET item_name='$item_name', item_description='$item_description', item_price='$item_price', item_file='$show_path' WHERE  s_no= $hidden_item_field;";

            $result=$conn -> Execute($sql_insert);
            if ($result){
                $conn -> json_true(150, "Update Successfully image");
            }
            else{
                $conn -> json_true(155, "item already exist ");
            }
        }
        else{
            $sql_insert="UPDATE item_master SET item_name='$item_name', item_description='$item_description', item_price='$item_price' WHERE  s_no= $hidden_item_field;";
            // print_r($sql_insert);die;
            $result=$conn -> Execute($sql_insert);
            if ($result){
                $conn -> json_true(150, "Update Successfully");
            }
            else{
                $conn -> json_true(155, "item already exist ");
            }
        }
    };



};
$show_item_list = function () use ($conn) {   
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $recordsPerPage = $_POST['recordsPerPage'];

    $search_item= $conn -> test_input($_POST['search_item']);
    $search_item_description= $conn -> test_input($_POST['search_item_description']);
    $search_item_price= $conn -> test_input($_POST['search_item_price']);

    $column_name=$_POST['column_name'];
    $sorting=$_POST['sorting'];

    $offset = ($page - 1) * $recordsPerPage;

    $wherestr = "1=1 ";
    if ($search_item_price != "") {
        $wherestr .= " and item_price = '" . $search_item_price . "'";
    }   

    $sql_item = "SELECT * FROM item_master WHERE item_name LIKE '%$search_item%' and item_description like '%$search_item_description%' and $wherestr ORDER BY $column_name $sorting ";
    $temp =$sql_item;
    $sql_item .= "LIMIT $offset, $recordsPerPage";


    
    // print_r($sql_item);die;

    $result=$conn -> Execute($sql_item);
    if ($result) {
        $output = "";
        if ($conn -> num_rows($result) > 0) {
            $serial = $offset + 1;
            while ($row = $conn -> fetch_assoc($result)) {
                
                $sid_d = $row['s_no'];
                $output .= "
                <tr>
                    <td class='show_u_data'>{$row['s_no']}</td>
                    <td class='show_u_data edit_btn_style' onclick='editItem({$sid_d})'>{$row['item_name']}</td>
                    <td class='show_u_data td-wrap' title='{$row["item_description"]}'>{$row['item_description']}</td>
                    <td class='show_u_data'><img src='img/{$row['item_file']}' width='60px'></td>
                    <td class='show_u_data price_c_width' style='text-align: end;' >{$row['item_price']}.00</td>
                    <td align='center'>
                        <button type='button' id='edit'  class='show_u_data' onclick='editItem({$sid_d})' style='border:none;background-color:transparent;'><i class='fa-regular fa-pen-to-square'></i></button>
                    </td>
                    <td align='center'>
                        <button type='button'  id='delt'  class='show_u_data' onclick='deleteItem({$sid_d})' style='border:none;background-color:transparent;'><i class='fa-regular fa-trash-can' style='color:red;'></i></button>
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
                $pagination .= "<button class='border pagination-btn $isActive' onclick='show_itemRec($i)' style= color: #fff; padding: 5px 10px; margin: 2px; border: 1px solid #337ab7;'>$i</button><br><br>";
            }
            echo json_encode(array('table' => $output, 'pagination' => $pagination));
        }
        else {
            // echo "<h2>No Record Found</h2>";
            $output="";
            $output="<tr><td colspan='6'><h4>No Record Found</h4></td></tr>";
            $pagination="";
        echo json_encode(array('table' => $output, 'pagination' => $pagination));
        }
    }
    else {
        echo json_encode(array('error' => 'Query failed: '));
    }

};
$deleteItem = function () use ($conn) {
    $Did=$_POST['id'];
    
    $sql5 = "delete from item_master where s_no =".$Did;
    // print_r($sql5);die;
    $result = $conn -> Execute($sql5);
    if ($result) {
        echo json_encode(array('success' => true, 'statuscode' => 155, 'message' => 'delete data successfully'));
    }
    else{
        echo json_encode(array('success' => true, 'statuscode' => 160, 'message' => 'This item reference to invoice'));
    };
};
$editItem = function () use ($conn) {
    
    $edit_id=$_POST['id'];
    
    $sql5 = "select * from item_master where s_no =".$edit_id;
    $result = $conn -> Execute($sql5);
    if ($result) { 
        $a =$conn -> fetch_array($result);
        $b = 'img/'.$a['item_file'];
        echo json_encode(array($a,$b));
    };
};

// condition =====================================================================
if(isset($_POST['type']) && $_POST['type']== 'insert_item'){
    $insert_item();
} 
elseif(isset($_POST['type']) && $_POST['type']== 'show_item'){
    $show_item_list();
} 
elseif(isset($_POST['type']) && $_POST['type']== 'deleteItem'){
    $deleteItem();
} 
elseif(isset($_POST['type']) && $_POST['type']== 'editItem'){
    $editItem();
} 
?>