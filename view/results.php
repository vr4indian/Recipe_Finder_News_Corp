
<div class="results col-md-12">

    <?php
    if (isset($recipeName)) {
        if (!empty($recipeName)) {
            echo "<h4 class='text-center'>\nFor Today ($cookingDate), the best one for you to cook is <strong>$recipeName.</strong></h4>\n";
        } else {
            echo "<h4 class='text-center'>\nFor Today ($cookingDate), <strong>Order Takeout</strong></h4>\n";
        }
    }
    ?>
</div>
