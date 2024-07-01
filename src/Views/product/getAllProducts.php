<h1>All Products</h1>

    <table>
        <thead>
            <tr>
                <?php
                // Check if data is not empty
                if (!empty($data)) {
                    // Get the keys from the first inner array
                    $headers = array_keys($data[0]);
                    // Generate table headers
                    foreach ($headers as $header) {
                        echo "<th>{$header}</th>";
                    }
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


