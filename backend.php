<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="style.css" media="screen"/>
  <style>
  *{
    font-family: arial;
  }
  .tracking-front-end{
    background-color: #f2f2f2;
    padding: 10px;
  }
  table, th, td{
    border-collapse: collapse;
    padding: 10px;
    font-family: arial;
    border: none;
  }
  th{
    background-color: #e6e6e6;
  }
  button{
    box-shadow: 0px;
    border-radius: 5px;
    background-color: #bcbdc0;
    padding: 10px;
    border-style: solid;
    -webkit-transition: background-color 0.5s;
    transition: background-color 0.5s;
  }
  button:hover{
    color: white;
    background-color: #58585a;
  }
  select{
    padding: 8px;
  }
  .fieldError{
    color: red;
    font-size: 10pt;
  }
  .fieldSuccess{
    color: green;
    font-size: 10pt;
  }
  </style>
</head>
<body>
  <div class="tracking-front-end">
       <h3>Enter a new order</h3>
       <form method="POST" action="add-new-order.php" class="form-inline">
          <input type="number" name="orderNumber" placeholder="Order Number" ><br>
          <input type="text" name="customer" placeholder="Customer"><br>
          <select name="orderStatus">
            <option value="Order Received">Order Received</option>
            <option value="Order Processing">Order Processing</option>
            <option value="Shipping">Shipping</option>
            <option value="Shipped">Shipped</option>
          </select>&nbsp
          <button type="submit">Submit</button>
       </form>

      <?php
        $fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        if(strpos($fullUrl, "entry=empty") == true){
          echo "<p class='fieldError'>You did not fill in all the fields</p>";
        }
        elseif(strpos($fullUrl, "entry=invalid-order-number") == true){
            echo "<p class='fieldError'>Invalid order number</p>";
        }
        elseif(strpos($fullUrl, "entry=invalid-customer-name-or-orderStatus") == true){
          echo "<p class='fieldError'>Invalid customer name or order status</p>";
        }elseif(strpos($fullUrl, "entry=success") == true){
          echo "<p class='fieldSuccess'>You have successfully added a new order</p>";
        }
      ?>

<br><br>
<h3>Search by order number or customer name</h3>
    <form method="POST" class="form-inline">
      <input type="text" name="orderNumberSearch" placeholder="Order Number"><br>
      <input type="text" name="customerSearch" placeholder="Customer Name"><br>
      <button type="submit">Search</button>
    </form>
    <br>

    <?php
    require'dbh.php';
      if(!isset($_POST['orderNumberSearch']) && !isset($_POST['customerSearch'])){
        echo "";
      }else{
      $orderNumber = mysqli_real_escape_string($link, $_POST['orderNumberSearch']);
      $customer = mysqli_real_escape_string($link, $_POST['customerSearch']);
      if(empty($orderNumber) && empty($customer)){
        echo "<p class='fieldError'>Enter order number or customer name</p>";
      }
      elseif(!preg_match("/^[0-9]*$/", $orderNumber)){
        echo "<p class='fieldError'>Enter valid order number (numbers only)</p>";
      }
      elseif(!preg_match("/^[a-zA-Z]*$/", $customer)){
        echo "<p class='fieldError'>Enter valid customer name</p>";
      }
      elseif(!empty($orderNumber) && empty($customer)){
        $sql = "SELECT * FROM orders WHERE order_number = ?;";
        $stmt = mysqli_stmt_init($link);
        if (!mysqli_stmt_prepare($stmt, $sql)){
          echo "SQL statement prepare failed";
        }else{
          mysqli_stmt_bind_param($stmt, "s", $orderNumber);
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);
          if(!$row = mysqli_fetch_assoc($result)){
            echo "<p class='fieldError'>No orders found</p>";
          }else{?>
               <br>
               <table>
                  <tr>
                    <th>Order Number</th>
                    <th>Name</th>
                    <th>Order Status</th>
                  </tr>
                  <tr>
                    <td><?php echo $row['order_number'];?> </td>
                    <td><?php echo $row['customer'];?> </td>
                    <td><?php echo $row['order_status'];?> </td>
                  </tr>
                </table>
                <?php
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
              $resultCheck = mysqli_num_rows($result);

              if($resultCheck == 0){
                echo "<p class='fieldError'>Customer not found</p>";;
              }else{?>
                 <br>
                 <table>
                    <tr>
                      <th>Order Number</th>
                      <th>Name</th>
                      <th>Order Status</th>
                    </tr>
                    <?php
                    while($row = mysqli_fetch_assoc($result)){?>
                    <tr>
                      <td><?php echo $row['order_number'];?> </td>
                      <td><?php echo $row['customer'];?> </td>
                      <td><?php echo $row['order_status'];?> </td>
                    </tr>
                  <?php } ?>
                  </table>
                  <?php
                }
              }
            }
          }
          mysqli_close($link);
    ?>
    </div>
  </body>
</html>
