
<?php
  require 'dbh.php';

  $orderNumber = mysqli_real_escape_string($link, $_POST['orderNumberSearch']);

  if(empty($orderNumber)){
    header("Location: frontend.php?search=empty");
    exit();
  }
  elseif(!preg_match("/^[0-9]*$/", $orderNumber)){
    header("Location: frontend.php?search=invalid-order-number");
    exit();
  }
  else{
    $sql = "SELECT * FROM orders WHERE order_number = ?;";
    $stmt = mysqli_stmt_init($link);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      echo "SQL statement prepare failed";
    }else{
      mysqli_stmt_bind_param($stmt, "s", $orderNumber);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if(!$row = mysqli_fetch_assoc($result)){
        header("Location: frontend.php?search=no-orders-found");
      }else{
          echo $row['order_number'] . " &nbsp&nbsp&nbsp" . $row['customer'] . "&nbsp&nbsp&nbsp" . $row['order_status'] . "<br>";
          }
        }
      }
