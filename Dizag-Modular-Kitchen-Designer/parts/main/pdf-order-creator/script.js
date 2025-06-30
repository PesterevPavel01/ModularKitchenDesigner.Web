function  InitializeCreatePdfOrderButton()
{
    let $createPdfOrderButton = $('#pdf-order-creator-btn');

    $createPdfOrderButton.off('click').on('click', function(e) {
        Process($createPdfOrderButton);
    });
}

function Process($createPdfOrderButton){

    if($createPdfOrderButton.hasClass('process'))
        return;
    
    $createPdfOrderButton.hide();
    $createPdfOrderButton.addClass('process');

    let $createPdfOrderSection = $('#pdf-order-creator-section');

    let $parameters = $createPdfOrderSection.find('#parameters').val().trim();

    $arParams = JSON.parse($parameters);

    let data = new FormData();
    data.append('action', "pdf_creator_process");
    //data.append('action', "pdf_order_creator");
    data.append('PARAMETERS', JSON.stringify($arParams));
    AjaxProcess(data, $createPdfOrderButton);
};

function AjaxProcess(data, unlockedElement) {
    $.ajax({
        type: 'POST',
        url: ajax_url,
        data: data,
        cache: false, //Обязательно указать false
        processData: false, //Обязательно указать false
        contentType: false, // Обязательно указать false
        
        success: function(response) {
            console.log(response);
            $('.content-pdf-download-link').attr('href', response.data);
            $('.content-pdf-download-link').addClass('active');
            console.log($('.content-pdf'));
            if(unlockedElement)
                $(unlockedElement).removeClass('process');
        }
    });
}