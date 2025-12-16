/**
 * Модуль для управления зависимыми выпадающими списками (Master-Slave)
 * Использование: MasterSlaveSelectsInit('[data-master]', '[data-slave]');
 * @param {string} masterAttr - CSS-селектор для master-элемента
 * @param {string} slaveAttr - CSS-селектор для slave-элемента
 */

 function MasterSlaveSelectsInit(masterAttr, slaveAttr) {
    
    $(document).off('change.masterSlaveGlobal', '[' + masterAttr + ']')
        .on('change.masterSlaveGlobal', '[' + masterAttr + ']', function() {
            var $master = $(this);
            var $slave = $('[' + slaveAttr + ']');

            UpdateSlaveList($master, $slave);
        });
}
/*
function  MasterSlaveSelectsRefresh(masterAttr, slaveAttr) {
     // Инициализация существующих элементов
     $('[' + masterAttr + ']').each(function() {

        var $master = $(this);

        var $slave = $('[' + slaveAttr + ']');

        UpdateSlaveList($master, $slave);
        
    });
}*/

// Обновление slave-списка (без изменений)
function UpdateSlaveList($master, $slave) {

    var selectedValue = $master.val();

    var $allOptions = $slave.find('option[data-master-value]');

    // Сбрасываем выбранное значение
    $slave.val('');

    // Скрываем все опции
    $allOptions.addClass('d-none');

    if (selectedValue) {

        // Показываем только соответствующие опции
        $allOptions.filter('[data-master-value="' + selectedValue + '"]')
                   .removeClass('d-none');
        // Активируем список
        $slave.prop('disabled', false);

    } else {

        // Деактивируем список
        $slave.prop('disabled', true);
        
    }
}