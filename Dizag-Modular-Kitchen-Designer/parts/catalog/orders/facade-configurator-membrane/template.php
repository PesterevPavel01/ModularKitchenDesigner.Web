<?
require_once get_template_directory() . '/core/services/processors/catalog/components/ComponentProvider.php';
require_once get_template_directory() . '/core/Result.php';

global $componentServiceUrl;?>

<?$components = isset($args['COMPONENTS']) ? $args['COMPONENTS'] : null; //компоненты модуля, который находится в режиме редактирования?>

<?$membraneCode = isset($args['MEMBRANE_CODE']) ? sanitize_text_field($args['MEMBRANE_CODE']) : "";

$supplierCode = '0000000SPLR';

$user = isset($args['USER']) ? sanitize_text_field($args['USER']) : "";

$role = isset($args['ROLE']) ? sanitize_text_field($args['ROLE']) : "";

$Result = new BaseResult();

$componentProvider = new ComponentProvider($componentServiceUrl, $user);

$Result = $componentProvider->GetComponentsByType($membraneCode);

if(!$Result->isSuccess())
{                    
    get_template_part("parts/catalog/errors/default-error-message/template", null, 
    [
        'TITLE' => $Result->ErrorMessage,
        'MESSAGE' => $Result->data
    ]);
    
    return;
}

$membranes = $Result->data;

$suppliers = array_filter(

    array_merge(...array_column($membranes, 'textParameters')),

    function($param) use($supplierCode){

        return isset($param['typeCode']) && 
            $param['typeCode'] === $supplierCode && 
            !empty($param['value']);
    }
);

$supplierValues = array_column($suppliers, 'value');

$supplierValues = array_unique($supplierValues);

sort($supplierValues, SORT_LOCALE_STRING | SORT_FLAG_CASE);

if($components)
{
    $selectedMembrane = array_filter($components, function($item) use ($membraneCode)
        {
            return $item['componentTypeCode'] === $membraneCode;
        }
    );

    $selectedMembrane = reset($selectedMembrane);
}

if($selectedMembrane)
{
    $parameters = $selectedMembrane['textParameters'];

    $selectedSupplier = array_filter($parameters, function($item) use ($supplierCode)
        {
            return $item['typeCode'] === $supplierCode;
        }
    );

    $selectedSupplier = reset($selectedSupplier);
}
?>

<li class="facade-configurator-membrane combobox-conteiner d-flex flex-column w-100 m-0">

    <label for="supplier-combobox" class="dark fw-bold p-1  m-0">поставщик</label>

    <select id="supplier-combobox" class="configurator-combobox" data-membrane-master class="form-select">

        <option value="0"></option>

        <?foreach ($supplierValues as $supplier) {?>

            <option value="<?=esc_attr($supplier)?>" 
            <?= (!empty($selectedMembrane) && $selectedSupplier['value'] === $supplier ) ? 'selected' : ''?>><?= esc_html($supplier)?></option>

        <?}?>

    </select>

    <input type="hidden" value="<?= empty($components) ? "" : $selectedMembrane['componentCode']?>" class="combobox-input membrane w-100" name="MEMBRANE" id = "order-item-configurator-membrane"/>

    <input type="hidden" data-no-reset="true" value="<?= $membraneCode ?>" name="MEMBRANE_TYPE_CODE"/>

    <label for="membrane-combobox" class="membrane-combobox-label dark fw-bold p-1  m-0">пленка</label>

    <select class="configurator-combobox" data-membrane-slave id="membrane-combobox">

        <option value="0"></option>

        <?foreach ($membranes as $membrane) {

            $parameters = $membrane['textParameters'];

            $currentSupplier = array_filter($parameters, function($item) use ($supplierCode)
                {
                    return $item['typeCode'] === $supplierCode;
                }
            );

            $currentSupplier = reset($currentSupplier);?>

            <option value="<?= esc_attr($membrane['componentCode'])?>" 
                
                data-master-value=<?= esc_html($currentSupplier['value']) ?>
                
                <?= (!empty($selectedMembrane) && $membrane['componentCode'] === $selectedMembrane['componentCode']) ? 'selected' : ''?>

                class = "<?= (empty($selectedSupplier) ? 'd-none' : '')?> <?= (!empty($selectedSupplier) && $currentSupplier['value'] != $selectedSupplier['value'] ? 'd-none' : '')?>">
                
                <?= $membrane['componentTitle'] ?>

            </option>
            <?
        }?>

    </select>
    
</li>