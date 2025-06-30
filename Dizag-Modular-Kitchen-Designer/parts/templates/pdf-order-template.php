<h2>Модульная кухня "<?=$args['KITCHEN_TYPE']['title']?>"</h2>

<p>Материалы:</p>
<ul class = "list">
    <li><p>Верх: <?=$args['MATERIALS']['TOP']['VALUE']['TITLE']?></p></li>
    <li><p>Низ: <?=$args['MATERIALS']['BOTTOM']['VALUE']['TITLE']?></p></li>
</ul>

<p>Модули:</p>
<ul class = "list">
<?foreach ($args['SECTIONS'] as $section) {?>
    <li><p><?=$section['moduleCode']?> - <?=$section['quantity']?> шт.</p></li>
<?}?>
</ul>
<br>
<br>
<?get_template_part("parts/main/specification/specification",null,
        [
            'PARAMETER' => [
                'SPECIFICATION' =>$args['SPECIFICATION']
            ]
        ]);
?>
<style>
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
        padding: 0 10px;
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
        padding: 2px 4px;
    }

    p{
        font-size: 10px;
    }
</style>