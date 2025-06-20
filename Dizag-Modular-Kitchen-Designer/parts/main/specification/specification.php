<?
    $specification = $args['PARAMETER']['SPECIFICATION'];
    if($specification === null || empty($specification) )
        return;
?>


<block class="flex-column-start custom-kitchen-specification gap20">
        <?get_template_part("parts/main/titles/section-title",null,
            [
                'PREFIX' => 'ИТОГОВАЯ',
                'TEXT' => 'СПЕЦИФИКАЦИЯ'
            ]);?>
        
        <ul class="table gap40">
            
            <li class="table-row">
                <?php foreach($specification[0] as $key => $value) { ?>
                    <p class="table-cell order-value-content grey"> 
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
                        case "totalPrice":
                            echo "Сумма";
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
                <?php } ?>
            </li>

            <?foreach($specification as $specificationItem){?>

                <li class="table-row">

                        <?foreach($specificationItem as $value){?>

                                <p class="table-cell order-value-content black"> 
                                    <?=$value?>
                                </p> 

                        <?}?>

                </li>

            <?}?>

        </ul>

    </block>