<?
enqueue_template_part_styles_scripts( __DIR__, "approval-customer-list");
?>

<section class="approval-customer-list d-flex flex-column align-items-center justify-content-center w-100">
    
    <section class="oder-list-section d-flex flex-column align-items-start justify-content-start gap20 w-100">

        <t2 class="title">Новые клиенты</t2>

        <div class="list-items flex-column-start gap2">
            <?for($item = 1; $item < 10; $item++){
                get_template_part("parts/catalog/account/approval-costomer-list-item/template", null,                 
                [
                    'PARAMETER' =>  [
                        'CLIENT_NAME' => 'Педпенеков Роман',
                        'CLIENT_LOGIN' => 'Roman'
                    ]
                ]);
            }?>
        </div>
        
    </section>
    
</section>