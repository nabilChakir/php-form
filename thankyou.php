<?php

echo "<h3>Form submitted successfully, here is a recap:</h3>";

foreach ($_GET as $key => $value) {
    echo "<p> <bold>" . $key . "</bold> : <span style='color: blue'>" . $value . "</span> </p>";
}

echo "<img src='./uploads/".$value."' alt='' width='250' height='250'>";

?>