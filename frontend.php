<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="style.css" media="screen" />
</head>
  <body>
<h5>Enter your order number</h5>
    <form method="POST" action="search-orders-frontend.php" class="form-inline">
      <input type="text" name="orderNumberSearch" placeholder="Order Number"><br>
      <button type="submit">Search</button>
    </form>
    <?php
      $fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
      if(strpos($fullUrl, "search=invalid-order-number") == true){
        echo "<p>Invalid order number</p>";
      }
      elseif(strpos($fullUrl, "search=empty") == true){
        echo "<p>Enter an order number</p>";
      }
      elseif(strpos($fullUrl, "search=no-orders-found") == true){
        echo "<p>No orders found</p>";
      }
    ?>
  </body>

</html>
