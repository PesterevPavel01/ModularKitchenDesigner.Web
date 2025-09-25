<?
$key = $args['PARAMETER']['KEY'];
$value = $args['PARAMETER']['VALUE'];
?>

<p class="table-cell order-value-content
    <?=($key === "title" 
        || $key === "unitPrice" 
        || $key === "totalPrice"
        || $key === "discountedUnitPrice"
        || $key === "discountedTotalPrice"
        || $key === "quantity") 
        ? " black" 
        : " grey medium-font mobile-none"?>

    <?=($key === "title" 
        || $key === "code"
        //|| $key === "model"
        //|| $key === "material"
        || $key === "unitPrice" 
        || $key === "discountedUnitPrice"
        || $key === "totalPrice"
        || $key === "discountedTotalPrice"
        || $key === "quantity") 
        ? "" 
        : " none"?>

    <?=$key === "totalPrice" ? " m-width-120 normal-font" : ""?>
    <?=$key === "quantity" ? " m-width-70" : ""?>
    <?=$key === "unitPrice" ? " m-width-100" : ""?>

    <?=($key != "title" && $key != "unitPrice" && $key != "discountedUnitPrice" && $key != "totalPrice"&& $key != "discountedTotalPrice"  && $key != "quantity" && $key != "code") ? " pdf-none" : ""?>
        ">
    <?=($key === "unitPrice" || $key === "discountedUnitPrice"|| $key === "totalPrice"|| $key === "discountedTotalPrice") ? number_format((float)$value,0,',',' ') : $value?>
</p> 