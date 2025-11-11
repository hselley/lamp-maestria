<!DOCTYPE html>
<html>
  <body>
    <?php
      echo "<p>" . date("Y-m-d H:i:s") . "</p>";
    
      $t=date("H");
      if ($t<"20") {
          echo "<p>Have a good day!</p>";
      }
    ?>
  </body>
</html>