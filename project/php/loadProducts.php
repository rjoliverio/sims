<?php
    echo "<script src='../js/purchase.js'></script>";
    $conn = mysqli_connect("localhost", "root", "", "sims");
    $item = substr($_POST['item'], 0, 5);
    if(is_numeric($item)){
        $query = "SELECT * FROM products WHERE Prod_id =".$item;
    }else{
        $query = "SELECT * FROM products WHERE ProdName ='".$_POST['item']."'";
    }
    $rs = mysqli_query($conn, $query);
    if($rs != NULL){
        if(mysqli_num_rows($rs) > 0){
            $data = mysqli_fetch_assoc($rs);
            echo "<table class='table table-bordered mb-4 mt-3' id='modaltable' width='100%' cellspacing='0'>
                    <thead>
                            <tr>
                                <th width='10%'>Id</th>
                                <th width='30%'>Item</th>
                                <th width='13%'>Price</th>
                                <th width='10%'>Qty</th>
                                <th width='10%''>Disc%</th>
                                <th width='14%'>Total</th>
                                <th width='13%'></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id='tbody'>
                                <td>".$data['Prod_id']."</td>
                                <td>".$data['ProdName']."</td>
                                <td id='price'>".$data['Price']."</td>
                                <td contenteditable='true' id='qty'>0</td>
                                <td contenteditable='true' id='disc'>0</td>
                                <td id='total'>0.00</td>
                                <td>
                                    <button class='btn btn-primary pr-2 pl-2 pt-0 pb-0' type='button' id='plus'><i
                                            class='fas fa-plus'></i></button>
                                    <button class='btn btn-primary pr-2 pl-2 pt-0 pb-0' type='button' id='minus'><i
                                            class='fas fa-minus' ></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    ";
            }else{
                echo "<p class='alert alert-danger text-center p-0'>No results found.</p>";
            }
    }else{
        echo "<p class='alert alert-danger text-center p-0'>No results found.</p>";
    }
?>