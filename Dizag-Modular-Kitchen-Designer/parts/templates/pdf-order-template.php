<img class="logo-icon cover height-100" src="<?=theme_image('logo',true,'/assets/img/')?>">
<h2>Модульная кухня "<?=$args['KITCHEN_TYPE']['title']?>"</h2>
<p>Материалы:</p>
<ul class = "list">
    <li><p>Верх: <?=$args['MATERIALS']['TOP']['VALUE']['TITLE']?></p></li>
    <li><p>Низ: <?=$args['MATERIALS']['BOTTOM']['VALUE']['TITLE']?></p></li>
</ul>

<p>Модули:</p>
<ul class = "list">
<?foreach ($args['SECTIONS'] as $section) {?>
    <li><p><?=$section['moduleTitle']?> ( <?=$section['moduleCode']?> ) - <?=$section['quantity']?> шт.</p></li>
<?}?>
</ul>
<br>
<br>
<?get_template_part("parts/main/specification/specification",null,
        [
            'PARAMETER' => [
                'SPECIFICATION' =>$args['SPECIFICATION'],
                'PRICE_TYPES' => $args['PRICE_TYPES'],
                'PRICE' => $args['PRICE']
            ]
        ]);
?>
<style>

    .height-100{
        height: 100px;   
    }

    .list {
        list-style-type: none;
        margin: 0;
        padding: 0;
    }

    li{
        margin: 0;
        padding: 0;
    }

    .list > li{
        padding: 0;
    }

    .custom-kitchen-specification{
        margin: 0;
        padding: 0;
    }

    .flex-column-start {     
        display: flex;
        flex-direction: column;
        align-items: start;
        justify-content: start;
        margin: 0;
        padding: 0;
    }

    .table{
        display: table;
        align-items: start;
        width: 100%;
        margin : 0;
        padding : 0;
    }

    .table-row{
        display: table-row;
        align-items: start;
        width: 100%;
        cursor: pointer;
        margin: 0;
        padding: 0;
    }

    .table-cell{
        display: table-cell;
        padding: 10px 10px 0 0;
        min-width: 60px;
    }

    .pdf-none{
        display: none;
    }

    p{
        font-size: 14px;
    }
    
    .table-cell{
        font-size: 12px;
    }
    .specification-module-title{
        padding-top: 10px;
        padding-bottom: 10px;
        border-top: 1px solid black;
        /*border-bottom: 1px solid var(--dark-blue-color);*/
        color:  rgb(11, 12, 80);
        font-size: 14px;
        background-color: #d0d1d1;
    }
</style>