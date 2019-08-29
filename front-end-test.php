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
    @keyframes bar-slide{
      from{width: 0%};
      to{width: 150px};
    }
    .outer-bar{
      width: 800px;
      display: block;

      padding: 0px;
      transform: skew(-20deg);
      background-color: #f2f2f2;
      overflow: hidden;
    }
    .inner-bar-filled{
      white-space: nowrap;
      background-color: #0c7d7a;
      display: inline-block;
      color: white;
      padding: 10px;
      text-align: center;
      font-size: 10pt;
    }
    .inner-bar-empty{
      background-color: #bcbdc0;
      white-space: nowrap;
      padding: 8px;
      display: inline-block;
      font-size: 10px;
      color: white;
      padding: 10px;
      text-align: center;
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
    <br>

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
        if(!mysqli_stmt_prepare($stmt, $sql)){
          echo "<p class='fieldError'>SQL stmt failed</p>";
        }else{
          mysqli_stmt_bind_param($stmt, "s", $orderNumber);
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);
          if(!$row = mysqli_fetch_assoc($result)){
            echo "<p class='fieldError'>No orders found</p>";
          }
          elseif($row['order_status'] == "order received"){ ?>
              <div class="outer-bar">
                <span class="inner-bar-filled">order receieved</span>
                <span class="inner-bar-empty">design</span>
                <span class="inner-bar-empty">production</span>
                <span class="inner-bar-empty">complete</span>
              </div>
          <?php }
            elseif($row['order_status'] == "design"){ ?>
                <div class="outer-bar">
                  <span class="inner-bar-filled">order receieved</span>
                  <span class="inner-bar-filled">design</span>
                  <span class="inner-bar-empty">production</span>
                  <span class="inner-bar-empty">complete</span>
                </div>
          <?php }
          elseif($row['order_status'] == "production"){ ?>
              <div class="outer-bar">
                <span class="inner-bar-filled">order receieved</span>
                <span class="inner-bar-filled">design</span>
                <span class="inner-bar-filled">production</span>
                <span class="inner-bar-empty">complete</span>
              </div>
            <?php }
            elseif($row['order_status'] == "complete"){ ?>
                <div class="outer-bar">
                  <span class="inner-bar-filled" style="background-color: green;">order receieved</span>
                  <span class="inner-bar-filled" style="background-color: green;">design</span>
                  <span class="inner-bar-filled" style="background-color: green;">production</span>
                  <span class="inner-bar-filled" style="background-color: green;">complete</span>
                </div>
              <?php } ?>
            <br><br>
             <table>
                <tr>
                  <th>Order Number</th>
                  <th>Name</th>
                  <th>Order Status</th>
                  <th>Completion Date</th>
                </tr>
                <tr>
                  <td><?php echo $row['order_number'];?></td>
                  <td><?php echo $row['name'];?></td>
                  <td><?php echo $row['order_status'];?></td>
                  <td><?php echo $row['completion_date'];?></td>

                </tr>
              </table>
              <?php
            }
          }
        }

        mysqli_close($link);
        ?>
      </div>
    </body>
</html>
