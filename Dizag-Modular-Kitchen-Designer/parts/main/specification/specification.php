<?
    global $Discount;
    $modules = $args['PARAMETER']['SPECIFICATION'];

    if($modules === null || empty($modules) )
        return;

    $kitchenPrice = $args['PARAMETER']['PRICE'];
?>

<block class="flex-column-start custom-kitchen-specification gap20">
        <?get_template_part("parts/main/titles/section-title",null,
            [
                'PREFIX' => 'ИТОГОВАЯ',
                'TEXT' => 'СПЕЦИФИКАЦИЯ'
            ]);?>
        
        <ul class="table gap40">
            <li class="table-row">
                <?foreach( $modules[0]['specification'][0] as $key => $value) 
                {?>
                    <?if(($args['PARAMETER']['PRICE_TYPES']['RETAIL'] && $args['PARAMETER']['PRICE_TYPES']['DISCOUNTED'])
                    || (!$args['PARAMETER']['PRICE_TYPES']['RETAIL'] && !$args['PARAMETER']['PRICE_TYPES']['DISCOUNTED'])):?>
                        <?if($key === "unitPrice" || $key === "totalPrice" ){?>  
                            <?get_template_part("parts/main/specification-row/specification-title-row",null,
                            [
                                'PARAMETER' =>[
                                    'KEY' => $key,
                                    'VALUE' => $value
                                ],
                                'PRICE_TYPES' => $args['PARAMETER']['PRICE_TYPES']
                            ]);?>

                            <?get_template_part("parts/main/specification-row/specification-title-row",null,
                            [
                                'PARAMETER' =>[
                                    'KEY' => $key === "unitPrice" ? "discountedUnitPrice" : "discountedTotalPrice",
                                    'VALUE' => $key === "unitPrice" ? "Цена со скидкой" : "Сумма  со скидкой"
                                ],
                                'PRICE_TYPES' => $args['PARAMETER']['PRICE_TYPES']
                            ]);?>

                        <?}
                        else{
                            ?>  
                            <?get_template_part("parts/main/specification-row/specification-title-row",null,
                            [
                                'PARAMETER' =>[
                                    'KEY' => $key,
                                    'VALUE' => $value
                                ],
                                'PRICE_TYPES' => $args['PARAMETER']['PRICE_TYPES']
                            ]);?>
                        <?}?>
                    <?elseif($args['PARAMETER']['PRICE_TYPES']['RETAIL']):?>
                        <?get_template_part("parts/main/specification-row/specification-title-row",null,
                        [
                            'PARAMETER' =>[
                                'KEY' => $key,
                                'VALUE' => $value
                            ],
                            'PRICE_TYPES' => $args['PARAMETER']['PRICE_TYPES']
                        ]);?>
                    <?elseif($args['PARAMETER']['PRICE_TYPES']['DISCOUNTED']):?>
                        <?if($key === "unitPrice" || $key === "totalPrice" )
                        {?>  
                            <?get_template_part("parts/main/specification-row/specification-title-row",null,
                            [
                                'PARAMETER' =>[
                                    'KEY' => $key === "unitPrice" ? "discountedUnitPrice" : "discountedTotalPrice",
                                    'VALUE' => $key === "unitPrice" ? "Цена со скидкой" : "Сумма  со скидкой"
                                ],
                                'PRICE_TYPES' => $args['PARAMETER']['PRICE_TYPES']
                            ]);?>
                        <?}
                        else{
                        ?>  
                            <?get_template_part("parts/main/specification-row/specification-title-row",null,
                            [
                                'PARAMETER' =>[
                                    'KEY' => $key,
                                    'VALUE' => $value
                                ],
                                'PRICE_TYPES' => $args['PARAMETER']['PRICE_TYPES']
                            ]);?>
                        <?}?>
                    <?endif;?>
                <?}?>
            </li>

            <?foreach($modules as $specification){?>         
                
                <?//print_r($specification);?>
                <?//print_r("<br><br>");?>
                <li class="table-row">
                    <p class='table-cell specification-module-title normal-font'><?=$specification['title'];?></p>
                    <p class='table-cell primary-dark specification-module-title mobile-none normal-font'><?=$specification['code'];?></p>
                    <p class='table-cell specification-module-title normal-font'><?=$specification['quantity'];?></p>

                    <?if(($args['PARAMETER']['PRICE_TYPES']['RETAIL'] && $args['PARAMETER']['PRICE_TYPES']['DISCOUNTED'])
                    || (!$args['PARAMETER']['PRICE_TYPES']['RETAIL'] && !$args['PARAMETER']['PRICE_TYPES']['DISCOUNTED'])){?>
                        <p class='table-cell specification-module-title normal-font'><?=number_format((float)$specification['price'],0,',',' ');?></p>
                        <p class='table-cell specification-module-title normal-font'><?=number_format((float)$specification['price'] * (1 - $Discount),0,',',' ');?></p>
                        <p class='table-cell specification-module-title normal-font'><?=number_format((float)$specification['totalPrice'],0,',',' ');?></p>
                        <p class='table-cell specification-module-title normal-font'><?=number_format((float)$specification['totalPrice'] * (1 - $Discount),0,',',' ');?></p>
                    <?}elseif($args['PARAMETER']['PRICE_TYPES']['RETAIL']){?>

                        <p class='table-cell specification-module-title normal-font'><?=number_format((float)$specification['price'],0,',',' ');?></p>
                        <p class='table-cell specification-module-title normal-font'><?=number_format((float)$specification['totalPrice'],0,',',' ');?></p>
                    
                    <?}else{?>

                        <p class='table-cell specification-module-title normal-font'><?=number_format((float)$specification['price'] * (1 - $Discount),0,',',' ');?></p>
                        <p class='table-cell specification-module-title normal-font'><?=number_format((float)$specification['totalPrice'] * (1 - $Discount),0,',',' ');?></p>

                    <?}?>

                </li>

                <?foreach($specification['specification'] as $specificationItem){?>
                    <li class="table-row">
                            <?foreach($specificationItem as $key => $value){?>
                                <?if(($args['PARAMETER']['PRICE_TYPES']['RETAIL'] && $args['PARAMETER']['PRICE_TYPES']['DISCOUNTED'])
                                || (!$args['PARAMETER']['PRICE_TYPES']['RETAIL'] && !$args['PARAMETER']['PRICE_TYPES']['DISCOUNTED'])):?>
                                    <?if($key === "unitPrice" || $key === "totalPrice" ){?>  
                                        <?get_template_part("parts/main/specification-row/specification-row",null,
                                        [
                                            'PARAMETER' =>[
                                                'KEY' => $key,
                                                'VALUE' => $value
                                            ],
                                            'PRICE_TYPES' => $args['PARAMETER']['PRICE_TYPES']
                                        ]);?>
                                        <?get_template_part("parts/main/specification-row/specification-row",null,
                                        [
                                            'PARAMETER' =>[
                                                'KEY' => $key === "unitPrice" ? "discountedUnitPrice" : "discountedTotalPrice",
                                                'VALUE' => $value * (1 - $Discount) 
                                            ],
                                            'PRICE_TYPES' => $args['PARAMETER']['PRICE_TYPES']
                                        ]);?>
                                    <?}else{?>
                                        <?get_template_part("parts/main/specification-row/specification-row",null,
                                        [
                                            'PARAMETER' =>[
                                                'KEY' => $key,
                                                'VALUE' => $value
                                            ],
                                            'PRICE_TYPES' => $args['PARAMETER']['PRICE_TYPES']
                                        ]);?>
                                    <?}?>
                                <?elseif($args['PARAMETER']['PRICE_TYPES']['RETAIL']):?>
                                    <?get_template_part("parts/main/specification-row/specification-row",null,
                                    [
                                        'PARAMETER' =>[
                                            'KEY' => $key,
                                            'VALUE' => $value
                                        ],
                                        'PRICE_TYPES' => $args['PARAMETER']['PRICE_TYPES']
                                    ]);?>
                                <?elseif($args['PARAMETER']['PRICE_TYPES']['DISCOUNTED']):?>
                                    <?if($key === "unitPrice" || $key === "totalPrice" ){?>  
                                        <?get_template_part("parts/main/specification-row/specification-row",null,
                                        [
                                            'PARAMETER' =>[
                                                'KEY' => $key === "unitPrice" ? "discountedUnitPrice" : "discountedTotalPrice",
                                                'VALUE' => $value * (1 - $Discount) 
                                            ],
                                            'PRICE_TYPES' => $args['PARAMETER']['PRICE_TYPES']
                                        ]);?>
                                    <?}else{?>
                                        <?get_template_part("parts/main/specification-row/specification-row",null,
                                        [
                                            'PARAMETER' =>[
                                                'KEY' => $key,
                                                'VALUE' => $value
                                            ],
                                            'PRICE_TYPES' => $args['PARAMETER']['PRICE_TYPES']
                                        ]);?>
                                    <?}?>
                                <?endif;?>
                            <?}?>
                    </li>

                <?}?>
            <?}?>
            <?//Итоговая строка?>
            <li class="table-row">
                <p class='table-cell specification-module-title normal-font'><?="ИТОГО"?></p>
                <p class='table-cell primary-dark specification-module-title mobile-none normal-font'></p>
                <p class='table-cell specification-module-title normal-font'></p>
                <?if(($args['PARAMETER']['PRICE_TYPES']['RETAIL'] && $args['PARAMETER']['PRICE_TYPES']['DISCOUNTED'])
                || (!$args['PARAMETER']['PRICE_TYPES']['RETAIL'] && !$args['PARAMETER']['PRICE_TYPES']['DISCOUNTED'])){?>
                    <p class='table-cell specification-module-title normal-font'></p>
                    <p class='table-cell specification-module-title normal-font'></p>
                    <p class='table-cell specification-module-title normal-font'><?=number_format((float)$kitchenPrice,0,',',' ');?></p>
                    <p class='table-cell specification-module-title normal-font'><?=number_format((float)$kitchenPrice * (1 - $Discount),0,',',' ');?></p>
                <?}elseif($args['PARAMETER']['PRICE_TYPES']['RETAIL']){?>

                    <p class='table-cell specification-module-title normal-font'></p>
                    <p class='table-cell specification-module-title normal-font'><?=number_format((float)$kitchenPrice,0,',',' ');?></p>
                
                <?}else{?>

                    <p class='table-cell specification-module-title normal-font'></p>
                    <p class='table-cell specification-module-title normal-font'><?=number_format((float)$kitchenPrice * (1 - $Discount),0,',',' ');?></p>

                <?}?>

            </li>
        </ul>
        
    </block>