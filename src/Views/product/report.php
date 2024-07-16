<div>

</div>
<?php if (isset($data) && empty($data)) echo "<h1>Nema takvih proizvoda</h1>"; ?>

<?php if (!empty($data)): ?>
      <table>
          <thead>
              <tr>
                  <?php 
                      
                      $headers = array_keys($data[0]);
                      
                      foreach ($headers as $header) {
                          echo "<th>{$header}</th>";
                      }
                  
                  ?>
              </tr>
          </thead>
          <tbody>
              <?php
              // Generate table rows
              foreach ($data as $row) {
                  echo "<tr>";
                  foreach ($row as $value) {
                      echo "<td>{$value}</td>";
                  }
                  echo "</tr>";
              }
              ?>
          </tbody>
      </table>
  <?php endif; ?>