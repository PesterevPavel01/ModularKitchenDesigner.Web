// SelectionHandler.js

    function Select($currentBtn, $updateButtons) {
        $currentBtn.toggleClass('active');

        $updateButtons.each(function() {
            if (!$(this).is($currentBtn)) {
                $(this).removeClass('active');
            }
        });
    }