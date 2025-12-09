<?php
//  print_r($a);
 $sql= "SELECT im.client_id,cm.name client_name,cm.email client_email,cm.mobile_no client_no,CONCAT(c.name,', ',s.name) AS address,iml.item_id,itm.item_name,iml.price,iml.quentity,iml.total FROM invoice_item_list AS iml LEFT JOIN invoice_master im ON im.id = iml.invoice_id LEFT JOIN client_master cm ON im.client_id=cm.id LEFT JOIN cities c ON cm.cities = c.id LEFT JOIN states s ON cm.state = s.id LEFT JOIN item_master itm ON itm.s_no = iml.item_id where iml.invoice_id=".$a;
 $result = $conn -> Execute($sql);

 if($result){
   $output="";     
   if($conn -> num_rows($result)>0){
     $output.="<tbody>"; 
       while($data = $conn -> fetch_array($result)){  
        
       $output .=" <tr>
           <td>{$data["item_name"]}</td>
           <td class='text-right'>{$data["price"]}.00</td>
           <td class='text-right'>{$data["quentity"]}</td>
           <td class='text-right'>{$data["total"]}.00</td>
       </tr>";
       $client_name=$data['client_name'];
       $client_email=$data['client_email'];
       $client_no=$data['client_no'];
       $address=$data['address'];     
       }
       $output.="</tbody>";
   }
}
 $sql1 ="select * from invoice_master where id=".$a;
 $result1 = $conn -> Execute($sql1);
 if($result1){
     while($data1 = $conn -> fetch_array($result1)){
       $date = $data1['created_date'];
      //  $date = date("d-m-Y", $created_date);
       $total_amount=$data1['total_amount'];  
     }   
 }
 


?>