

<?php
  require 'dbh.php';
  $orderNumber = mysqli_real_escape_string($link, $_POST['orderNumber']);
  $customer = mysqli_real_escape_string($link, $_POST['customer']);
  $orderStatus = mysqli_real_escape_string($link, $_POST['orderStatus']);

  if(empty($orderNumber) || empty($customer) || empty($orderStatus)){
    header("Location: backend.php?entry=empty");
    exit();
  }
  elseif(!preg_match("/^[0-9]*$/", $orderNumber)){
    header("Location: backend.php?entry=invalid-order-number");
    exit();
  }
  elseif(!preg_match("/^[a-zA-Z\s]*$/", $customer) || !preg_match("/^[a-zA-Z\s]*$/", $orderStatus)){
    header("Location: backend.php?entry=invalid-customer-name-or-orderStatus");
    exit();
  }
  else{
    $sql = "INSERT INTO orders(order_number, customer, order_status)
            VALUES(?, ?, ?)";
    $stmt = mysqli_stmt_init($link);
      if(!mysqli_stmt_prepare($stmt, $sql)){
        echo "SQL statement prepare failed";
      }else{
        mysqli_stmt_bind_param($stmt, 'iss', $orderNumber, $customer, $orderStatus);
          if(!mysqli_stmt_execute($stmt)){
            "order could not be added " . mysqli_error($link);
          }else{
              header("Location: backend.php?entry=success");
            }
          }
      }
