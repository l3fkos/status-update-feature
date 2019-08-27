
<?php
  require 'dbh.php';

  $orderNumber = mysqli_real_escape_string($link, $_POST['orderNumberSearch']);
  $customer = mysqli_real_escape_string($link, $_POST['customerSearch']);

  if(empty($orderNumber) && empty($customer)){
    header("Location: backend.php?search=empty");
    exit();
  }
  elseif(!preg_match("/^[0-9]*$/", $orderNumber)){
    header("Location: backend.php?search=invalid-order-number");
    exit();
  }
  elseif(!preg_match("/^[a-zA-Z]*$/", $customer)){
    header("Location: backend.php?search=invalid-customer-name-or-orderStatus");
    exit();
  }
  elseif(!empty($orderNumber) && empty($customer)){
    $sql = "SELECT * FROM orders WHERE order_number = ?;";
    $stmt = mysqli_stmt_init($link);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      echo "SQL statement prepare failed";
    }else{
      mysqli_stmt_bind_param($stmt, "i", $orderNumber);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if(!$row = mysqli_fetch_assoc($result)){
        header("Location: backend.php?search=no-orders-found");
      }else{
          echo $row['order_number'] . " &nbsp&nbsp&nbsp" . $row['customer'] . "&nbsp&nbsp&nbsp" . $row['order_status'] . "<br>";
          }
        }
      }
      elseif(empty($orderNumber) && !empty($customer)){
        $sql = "SELECT * FROM orders WHERE customer = ?;";
        $stmt = mysqli_stmt_init($link);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
          echo "SQL statement prepare failed";
        }else{
          mysqli_stmt_bind_param($stmt, "s", $customer);
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);
          if(!$row = mysqli_fetch_assoc($result)){
            header("Location: backend.php?search=no-orders-found");
          }else{
              echo $row['order_number'] . " &nbsp&nbsp&nbsp" . $row['customer'] . "&nbsp&nbsp&nbsp" . $row['order_status'] . "<br>";
              }
            }
          }
