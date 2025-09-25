
$(document).ready(TemplateInit);

function  TemplateInit()
{
    let $updateButtons = $(this).find('.costomer-order-list-item');

    $updateButtons.each(function() {
        console.log($updateButtons);
        $(this).off('click').on('click', function(e) {
            Select($(this), $updateButtons);
        });
    });
}

function Select($currentBtn, $updateButtons)
{
    $currentBtn.toggleClass('active');

    console.log($currentBtn);
    if(!$updateButtons)
        return;

    if ($updateButtons.length > 0) {
        $updateButtons.each(function() {
            if (!$(this).is($currentBtn))
                $(this).removeClass('active');
        });
    }
}
