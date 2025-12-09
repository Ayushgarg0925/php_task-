<?php 
include '../common/conn1.php';
require_once '../vendor/autoload.php';
include '../vendor/mailer.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;




$invoice_no = function () use ($conn) {
    $sql ="SELECT max(id)+1 AS id FROM invoice_master";
    $result= $conn -> Execute($sql);
    if($result){
        if($conn -> num_rows($result)>0){
            while($data = $conn -> fetch_array($result)){  
                $output=$data["id"]??1;     
            } 
            echo json_encode(array('success' => true, 'statuscode' => 200,'data'=> $output));
        }
    }
};

$client_name_invoice = function () use ($conn) {
    $c_name=$_POST['c_name'];
    $sql ="SELECT cm.id,cm.name,cm.email,cm.mobile_no,cm.address,s.name AS state,c.name AS cities FROM client_master cm 
    LEFT JOIN states s ON cm.State = s.id 
    LEFT JOIN cities c ON cm.cities = c.id
    where cm.name like '%$c_name%'";

    $result= $conn -> Execute($sql);
    if($result){
        if($conn -> num_rows($result)>0){
            while($data = $conn -> fetch_array($result)){  
                $output[]=$data;     
            } 
            
            echo json_encode(array('success' => true, 'statuscode' => 200,'data'=> $output));
        }
    }
};

$item_name_invoice = function () use ($conn) {
    $item_name=$_POST['c_name'];
    
    $sql ="SELECT * FROM item_master WHERE item_name like '%$item_name%' ";

    $result= $conn -> Execute($sql);
    if($result){
        if($conn -> num_rows($result)>0){
            while($data = $conn -> fetch_array($result)){  
                $output[]=$data;     
            } 
            
            echo json_encode(array('success' => true, 'statuscode' => 200,'data'=> $output));
        }
    }
};

$insert_invoiceMaster = function () use ($conn) {

    $invoice_hidden_input=$_POST['invoice_hidden_input'];
    $invoice_no=$_POST['invoice_no'];    
    $client_hid_id_invoice=$_POST['client_hid_id_invoice'];    
    $invoice_date=$_POST['invoice_date'];    
    $total_amount=$_POST['total_amount'];  
    $client_name_invoice=$_POST['client_name_invoice'];  

    // invoice item list
    $item_hid_id_name=$_POST['item_hid_id_name'];  
    $item_price_id=$_POST['item_price_id'];  
    $item_quantity_id=$_POST['item_quantity_id'];  
    $item_amount_id=$_POST['item_amount_id'];  
    $item_name_invoiec=$_POST['item_name_invoiec'];  
    $invoice_no1= str_replace('SAN-','',$invoice_no);

    include "val_client.php";

    if($invoice_hidden_input==""){

        $sql ="INSERT INTO invoice_master (client_id, created_date, total_amount) VALUES ($client_hid_id_invoice, '$invoice_date', $total_amount); ";
        $result=$conn -> Execute($sql);
        
        for($i=0;$i<count($item_name_invoiec);$i++){
            $i_id=$item_hid_id_name[$i];
            $i_price=$item_price_id[$i];
            $i_quantity=$item_quantity_id[$i];
            $i_amount=$item_amount_id[$i];
            $i_name=$item_name_invoiec[$i];
            
            include "val_item.php";
            
            $sql1="INSERT INTO invoice_item_list (invoice_id, item_id, price, quentity, total) VALUES ($invoice_no1, $i_id, $i_price, $i_quantity, $i_amount);";
            // print_r($sql1);die;
            
            $result1= $conn -> Execute($sql1);
        }

        if($result==true or $result1==true){
            echo json_encode(array('success' => true, 'statuscode' => 200,'message' => "inserted successfully!!"));
        }
        else{
            echo json_encode(array('success' => true, 'statuscode' => 250,'message' => "Require All Field"));
        };
    }

    else{
        $sql="UPDATE invoice_master SET client_id=$client_hid_id_invoice, created_date='$invoice_date', total_amount=$total_amount WHERE  id=$invoice_no1;";
        $result=$conn -> Execute($sql);
        
        $sql2 = "DELETE FROM invoice_item_list WHERE invoice_id=$invoice_no1;";
        $result=$conn -> Execute($sql2);
        
        for($i=0;$i<count($item_name_invoiec);$i++){
            $i_id=$item_hid_id_name[$i];
            $i_price=$item_price_id[$i];
            $i_quantity=$item_quantity_id[$i];
            $i_amount=$item_amount_id[$i];
            $i_name=$item_name_invoiec[$i];
            
            include "val_item.php";
            
            $sql1="INSERT INTO invoice_item_list (invoice_id, item_id, price, quentity, total) VALUES ($invoice_no1, $i_id, $i_price, $i_quantity, $i_amount);";
            
            $result1= $conn -> Execute($sql1);
        }

        if($result==true or $result1==true){
            echo json_encode(array('success' => true, 'statuscode' => 200,'message' => "update successfully!!"));
        }
        else{
            echo json_encode(array('success' => true, 'statuscode' => 250,'message' => "Require All Field"));
        };
    }
};

$show_record_invoiceMaster = function () use ($conn) {
    
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $recordsPerPage = $_POST['recordsPerPage'];

    $s_invoice_no = $conn -> test_input($_POST['s_invoice_no']);
    $s_i_name = $conn -> test_input($_POST['s_i_name']);
    $s_i_email = $conn -> test_input($_POST['s_i_email']);
    $s_mobile_no = $conn -> test_input($_POST['s_mobile_no']);
    $s_totel_amount = $conn -> test_input($_POST['s_totel_amount']);
    $s_i_date = $conn -> test_input($_POST['s_i_date']);

    $s_invoice_no1= str_replace('SAN-','',$s_invoice_no);
    // print_r($s_invoice_no1);die;

    $column_name = $_POST['column_name'];
    $sorting = $_POST['sorting'];


    $offset = ($page - 1) * $recordsPerPage;

    $wherestr = "1=1 ";
    if ($s_invoice_no1 != "") {
        $wherestr .= " and im.id = '" . $s_invoice_no1 . "'";
    }
    else if ($s_i_date != "") {
        $wherestr .= " and im.created_date = '" . $s_i_date . "'";}
     else if ($s_i_name != "") {
        $wherestr .= " and cm.name like '" . '%' . $s_i_name . '%' . "'";
    } else if ($s_i_email != "") {
        $wherestr .= " and cm.email = '" . $s_i_email . "'";
    } else if ($s_mobile_no != "") {
        $wherestr .= " and cm.mobile_no = '" . $s_mobile_no . "'";
    } else if ($s_totel_amount != "") {
        $wherestr .= " and im.total_amount = '" . $s_totel_amount . "'";
    }
    
    // $sql= "SELECT im.id, cm.name, cm.email, cm.mobile_no,CONCAT(c.name,', ',s.name) AS address, im.total_amount,im.created_date FROM invoice_master AS im LEFT JOIN client_master cm ON im.client_id = cm.id LEFT JOIN cities c ON cm.cities = c.id LEFT JOIN states s ON cm.state = s.id where im.id like '%$s_invoice_no1%' and cm.name like '%$s_i_name%' and cm.email like '%$s_i_email%' and cm.mobile_no like '%$s_mobile_no%' ORDER BY $column_name $sorting ";

    $sql= "SELECT im.id, cm.name, cm.email, cm.mobile_no,CONCAT(c.name,', ',s.name) AS address, im.total_amount,im.created_date FROM invoice_master AS im LEFT JOIN client_master cm ON im.client_id = cm.id LEFT JOIN cities c ON cm.cities = c.id LEFT JOIN states s ON cm.state = s.id where $wherestr ORDER BY $column_name $sorting ";

    // print_r($sql);die;
    $temp=$sql;
    $sql .= " LIMIT $offset, $recordsPerPage ";

    $result= $conn -> Execute($sql);
    if($result){
        $output="";     
        if($conn -> num_rows($result)>0){
            $serial = $offset + 1;
            while($data = $conn -> fetch_array($result)){  
                // print_r($data);die;
                // print_r($data);
                $sid_d = $data['id'];
                $name = $data['name'];
                $email = $data['email'];
                $date = $data['created_date'];
                // $date1 = date_format('d-m-Y',$date);
                $date1 = date("d-m-Y", strtotime($date)); 
                // print_r($date1);die;
            $output .=" <tr>
                <td class='show_u_data'>{$data["id"]}</td>
                <td class='show_u_data'>SAN-{$data["id"]}</td>
                <td class='show_u_data'>{$date1}</td>
                <td class='show_u_data edit_btn_style' onclick='edit_invoice_data({$sid_d})'>{$data["name"]}</td>
                <td class='show_u_data td-wrap' title='{$data["email"]}'>{$data["email"]}</td>
                <td class='show_u_data'>{$data["mobile_no"]}</td>
                <td class='show_u_data td-no'style='text-align: right;'>{$data["total_amount"]}.00</td>
                <td class='show_u_data'>
                    <i class='fa-regular fa-pen-to-square' onclick='edit_invoice_data({$sid_d})'
                        style='color: #000000; font-size: x-large; cursor: pointer;'></i>
                </td>
                <td class='table_h'>
                    <i class='fa-regular fa-file-pdf' onclick='create_invoice({$sid_d})' style='color: #ff0000; font-size: x-large;cursor: pointer;'></i>
                </td>
                <td class='table_h'>
                    <i class='fa-regular fa-envelope' style='color:red; font-size: x-large;cursor: pointer;' onclick='openEmailModal({$sid_d},`{$name}`,`{$email}`,`{$date}`)'></i>
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
                $pagination .= "<button class='border pagination-btn $isActive' onclick='show_invoice_record($i)' style= color: #fff; padding: 5px 10px; margin: 2px; border: 1px solid #337ab7;'>$i</button><br><br>";
            }
            echo json_encode(array('table' => $output, 'pagination' => $pagination));
        }else {
            // echo "<h2>No Record Found</h2>";
            $output="";
            $output="<tr><td colspan='10'><h2>No Record Found</h2></td></tr>";
            $pagination="";
        echo json_encode(array('table' => $output, 'pagination' => $pagination));
        }
    } else {
        echo json_encode(array('error' => 'Query failed: '));
    }
};

$edit_invoice_data = function ($Edit_id) use ($conn) {
    $sql= "SELECT im.client_id,cm.name client_name,cm.email client_email,cm.mobile_no client_no,CONCAT(c.name,', ',s.name) AS address,iml.item_id,itm.item_name,iml.price,iml.quentity,iml.total FROM invoice_item_list AS iml LEFT JOIN invoice_master im ON im.id = iml.invoice_id LEFT JOIN client_master cm ON im.client_id=cm.id LEFT JOIN cities c ON cm.cities = c.id LEFT JOIN states s ON cm.state = s.id LEFT JOIN item_master itm ON itm.s_no = iml.item_id where iml.invoice_id=".$Edit_id;
    // print_r($sql);die;

    $result = $conn -> Execute($sql);

    $sql1 ="select * from invoice_master where id=".$Edit_id;

    if($result){
        $invoice_data_ = array();
            while($data = $conn -> fetch_array($result)){  
                $invoice_data_[] = $data;     
            }
        
    
        
    $result1 = $conn -> Execute($sql1);
    if($result1){
        $invoice_list_data = array();
             $invoice_list_data[]= $conn -> fetch_array($result1);
        $combinedData = array(
            'result_list' => $invoice_data_,
            'result_master_list' => $invoice_list_data
            
        );
        if ($result) {
            // echo json_encode("delete");
            echo json_encode(array('success' => true, 'statuscode' => 200, 'data' => $combinedData));
        }

    }else {
        echo json_encode(array('success' => false, 'statuscode' => 400, 'message' => ' Record not found !... '));
    }
    }else {
        echo json_encode(array('success' => false, 'statuscode' => 400, 'message' => ' Record not error  '));
    }   
};

$create_invoice = function ($i_id) use ($conn) {
  $a=$i_id;
  $mpdf = new \Mpdf\Mpdf();
  ob_start();
  include 'invoice_design.php';
  $HTMLoutput = ob_get_contents();
  ob_end_clean();

  $mpdf->WriteHTML($HTMLoutput);
  $mpdf->Output("media/invoice_(".$i_id.").pdf",'F');
  $content = file_get_contents("media/invoice_(".$i_id.").pdf");
  // unlink("media/invoice_(".$i_id.").pdf");
  exit(base64_encode($content));
  // header("Content-Disposition: attachment; filename=" . 'file.pdf');

};

$sendEmail = function () use ($conn) {
    $a = $_POST['email_hid_inp'];
    $clientEmail = $_POST['recipientEmail'];
    $emailSubject = $_POST['emailSubject'];
    $date = $_POST['date'];
    $emailBody = $_POST['emailBody'];
    
    include '../common/backend_invoice_design.php';

    $a=$a;
    $mpdf = new \Mpdf\Mpdf();
  ob_start();
  include 'invoice_design.php';
  $HTMLoutput = ob_get_contents();
  ob_end_clean();

  $mpdf->WriteHTML($HTMLoutput);
  $xyz="media/invoice_(".$a.").pdf";
  $mpdf->Output($xyz,'F');

  $mailer = new mailer();
  $attachArr['attachment'] = array(
      array('file' => $xyz, 'name' => "invoice" . $a)
  );

  $emailResponse = $mailer->sendEmail($clientEmail, $emailSubject, $emailBody, $attachArr);
  echo $emailResponse;
};
            
if(isset($_POST['type']) && $_POST['type']== 'show_client'){
    $client_name_invoice();
}
elseif(isset($_POST['type']) && $_POST['type']== 'show_item'){
    $item_name_invoice();
}
elseif(isset($_POST['type']) && $_POST['type']== 'invoice_no'){
    $invoice_no();
}
elseif(isset($_POST['type']) && $_POST['type']== 'insert_invoiceMaster'){
    $insert_invoiceMaster();
}
elseif(isset($_POST['type']) && $_POST['type']== 'invoice_record'){
    // print_r($_POST);die;
    $show_record_invoiceMaster();
}
elseif(isset($_POST['type']) && $_POST['type']== 'edit_invoice'){
    $Edit_id=$_POST['id'];
    $edit_invoice_data($Edit_id);
}
elseif(isset($_POST['type']) && $_POST['type']== 'create_invoice'){
    $i_id=$_POST['id'];
    $create_invoice($i_id);
}
elseif(isset($_POST['type']) && $_POST['type']== 'sendEmail'){
    $sendEmail();
};


?>