<?php
    //export.php  
    $output = '';
    if(isset($_GET["x"]))
    {
     $rows=json_decode($_GET["x"]);
      $output .= '
       <table class="table" bordered="1">
       <tr>ShopNimo Product List</tr>
       <tr>
           <th>Product ID</th>
           <th>Product Name</th>
           <th>Product Type</th>
           <th>Quantity</th>
           <th>Price</th>
           <th>Date Added</th>
           <th>Expiry Date</th>
           <th>Supplier</th>
       </tr>
      ';
      foreach($rows as $row)
      {
       $output .= '
       <tr>
       <td>'. $row->prodid.'</td>
       <td>'. $row->prodname.'</td>
       <td>'. $row->prodtype.'</td>
       <td>'. $row->qty.'</td>
       <td>'. $row->price.'</td>
       <td>'. $row->dateadded.'</td>
       <td>'. $row->expirydate.'</td>
       <td>'. $row->supplier.'</td>
    </tr>
       ';
      }
      $output .= '</table>';
      header('Content-Type: application/xls');
      header('Content-Disposition: attachment; filename=products.xls');
      echo $output;
    }
?>