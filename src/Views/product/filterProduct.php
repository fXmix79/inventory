<div class="container">
        <form method="post" action="?page=filterProduct">
            Pretraži po imenu: <input type="text" name="search" value=<?php echo isset($_POST['search']) ?  $_POST['search'] : "*" ?> required>
            Min. Količina: <input type="number" name="min_quantity" value=<?php echo isset($_POST['min_quantity']) ?  $_POST['min_quantity'] : 0 ?> required>
            Max. Količina: <input type="number" name="max_quantity" value=<?php echo isset($_POST['max_quantity']) ?  $_POST['max_quantity'] : 999 ?> required>
            <input type="submit" value="Filter">
        </form>

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
                   
