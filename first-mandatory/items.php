<?php
$_title = 'Items';
require_once('items-api.php');
require_once('components/header.php');
?> 

 <nav class="items_nav">
    <a href="user">Profile</a>
    <a class="active_link" href="items">Items</a>
    <a href="logout">Logout</a>
  </nav><br>
  <h1>Items</h1>  
<div class="items-container">
<table>
  <tr class="t_headers">
    <th><b>ID</b></th>
    <th><b>Name</b></th>
    <th><b>Price</b></th>
  </tr>


    <?php

foreach ($items as $item) {
    echo "<tr class='item'><th>{$item['item_id']}</th><th>{$item['item_name']}</th><th>{$item['item_price']}</th></tr>\n";    
  }
    ?>
    </table>
    </div>
<?php

require_once('components/footer.php');
?>    
