<?php
    session_start();
    $email =$_SESSION['formdata'];
    $name = $_POST['name'];
    $desc =$_POST['desc'];
    $tools = $_POST['tools'];
    $startDate =$_POST['sd'];
    $endDate =$_POST['ed'];
    // echo $email;
//     if (!function_exists('mysqli_init') && !extension_loaded('mysqli')) {  
//         echo 'We don\'t have mysqli!!!';  
//  } else {  
//      echo 'mysqli is installed';
//  }
    $conn= new mysqli("localhost","dave(2)","ensf409","tracker");
    

    if($conn->connect_error){
        die("Failed to connect: ".$con->connect_error);
    }else{
        $stmt = $conn->prepare("select * from login where email = ?"); //prevent sql injection
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $stmt_result = $stmt->get_result();
        if($stmt_result->num_rows > 0){
            $data = $stmt_result->fetch_assoc();
            $login = $data['loginID'];
                if($stmt_result->num_rows > 0){
                    $stmt = $conn->prepare("insert into projects (loginID,projectDesc,tools) values (?,?,?)"); //prevent sql injection
                    $stmt->bind_param("iss",$login,$desc,$tools);
                    $stmt->execute();
                    
                    session_start();
                    $_SESSION['formdata'] = $email; //or whatever
                    header('Location: projects.php');
                    exit;
                }
            }
        }
    
?>
