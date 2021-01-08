<?php
    include_once('dbconnect.php');
    if(isset($_POST['data'])){
        $sql="SELECT * FROM products WHERE Prod_id={$_POST['data']}";
        $res=mysqli_query($conn,$sql);
        $res=mysqli_fetch_assoc($res);
        echo "<tr><td>".$_POST['prodcount']."</td>
                <td>".$res['Prod_id']."</td>
                <td>".$res['ProdName']."</td>
                <td id='prodprice'>".$res['Price']."</td>
                <td id='prodqty' contenteditable='false'><i class='fas fa-minus-circle text-danger qtyadd qtyminus float-left'></i> <span class='qtynum'> 1 </span><i class=' float-right fas fa-plus-circle text-danger qtyplus qtyadd'></i></td>
                <td>0</td>
                <td id='prodtotal'>".$res['Price']."</td>
                <td>
                    <button class='btn btn-primary pr-2 pl-2 pt-0 pb-0' type='button'><i
                            class='fas fa-times' id='proddelete'></i></button>
                </td></tr>";
    }
?>