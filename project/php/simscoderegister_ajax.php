<?php
    include_once('dbconnect.php');
    if(isset($_POST['myJson'])){
        $data=json_decode($_POST['myJson']);
        $query="INSERT INTO person_info(Fname,Lname,Email,Contact_no,Address,Age,Gender,Person_type) 
                VALUES('$data->fname','$data->lname','$data->email','$data->contactnum','$data->address',$data->age,'$data->gender','Customer')";
        if(mysqli_query($conn,$query)){
            $query="SELECT * FROM person_info ORDER BY Person_id desc LIMIT 1";
            $res=mysqli_query($conn,$query);
            $res=mysqli_fetch_assoc($res);
            $date=(((int)date("Y"))+2)."/".date("m/d");
            $query="INSERT INTO simscode_membership(Person_id,Points,Expiry_date) VALUES($res[Person_id],0,'$date')";
            if(mysqli_query($conn,$query)){
                // $query="SELECT SIMS_code FROM simscode_membership ORDER BY SIMS_code desc LIMIT 1";
                // $res=mysqli_query($conn,$query);
                // $res=mysqli_fetch_assoc($res);
                $query="SELECT * FROM simscode_membership INNER JOIN person_info ON simscode_membership.Person_id=person_info.Person_id WHERE simscode_membership.SIMS_code=(SELECT SIMS_code FROM simscode_membership ORDER BY SIMS_code desc LIMIT 1)";
                $res=mysqli_query($conn,$query);
                $res=mysqli_fetch_assoc($res);
                echo json_encode($res);
            }else{
                echo "Error";
            }
        }else{
            echo "Error";
        }
    }
?>