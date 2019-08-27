<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="style.css" media="screen" />
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

    .fieldError{
      color: red;
      font-size: 10pt;
    }
  </style>
</head>
  <body>
    <div class="tracking-front-end">
    <h3>Enter your order number</h3>
    <form method="POST" class="form-inline">
      <input type="text" name="orderNumberSearch" placeholder="Order Number">
      <button type="submit">Search</button>
    </form>

    <?php
    require 'dbh.php';
    if(isset($_POST['orderNumberSearch'])){
      $orderNumber = mysqli_real_escape_string($link, $_POST['orderNumberSearch']);
      if(empty($orderNumber)){
        echo "<p class='fieldError'>Enter an order number</p>";
      }
      elseif(!preg_match("/^[0-9]*$/", $orderNumber)){
        echo "<p class='fieldError'>Enter a valid order number (numbers only)</p>";
      }
      else{
        $sql = "SELECT * FROM orders WHERE order_number = ?;";
        $stmt = mysqli_stmt_init($link);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
          echo "<p class='fieldError'>SQL stmt failed</p>";
        }else{
          mysqli_stmt_bind_param($stmt, "s", $orderNumber);
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);
          if(!$row = mysqli_fetch_assoc($result)){
            echo "<p class='fieldError'>No orders found</p>";
          }else{ ?>
            <br><br>
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
      }
      if(isset($row)){
        if($row['order_status'] == "shipped"){
              ?>
          <img src="skyline.jpg" width="200px">
          <?php
      }
    }
      mysqli_close($link);
        ?>
      </div>
    </body>
</html>
