    <?
    $key = $args['PARAMETER']['KEY'];
    $value = $args['PARAMETER']['VALUE'];
    ?>
    <p class="table-cell order-value-content grey
        <?=($key === "title" 
            || $key === "unitPrice" 
            || $key === "discountedUnitPrice"
            || $key === "totalPrice"
            || $key === "discountedTotalPrice"
            || $key === "quantity") 
            ? "" 
            : " mobile-none"?>
        <?=($key === "title" 
            || $key === "code"
            //|| $key === "model"
            //|| $key === "material"
            || $key === "unitPrice" 
            || $key === "totalPrice"
            || $key === "discountedUnitPrice" 
            || $key === "discountedTotalPrice"
            || $key === "quantity") 
            ? "" 
            : " none"?>

        <?=($key != "title" && $key != "unitPrice" && $key != "discountedUnitPrice" && $key != "totalPrice" 
        && $key != "discountedTotalPrice"  && $key != "quantity" && $key != "code") ? " pdf-none" : ""?>
    "> 
        <?php switch ($key) {
            case "title":
                echo "Компонент";
                break;
            case "code":
                echo "Код";
                break;
            case "quantity":
                echo "Кол";
                break;
            case "unitPrice":
                echo "Цена";
                break;
            case "discountedUnitPrice":
                echo "Цена со скидкой";
                break;
            case "totalPrice":
                echo "Сумма";
                break;
            case "discountedTotalPrice":
                echo "Сумма со скидкой";
                break;
            case "model":
                echo "Модель";
                break;
            case "componentType":
                echo "Вид";
                break;
            case "material":
                echo "Материал";
                break;
            default:
                echo "Элемент";
        } ?>
    </p>