<?$json_data = htmlspecialchars(json_encode($args['PARAMETERS'], JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT | JSON_HEX_APOS), ENT_QUOTES, 'UTF-8');
?>
<block class = "pdf-order-creator-section" id = "pdf-order-creator-section">
    <input type = "hidden" name="generate_pdf" value="1">
    <input type = "hidden" id="parameters" value="<?=$json_data?>">
    <div class = "custom-btn black" id = "pdf-order-creator-btn" type="submit">Сформировать заявку в PDF</div>
    <a class="content-pdf-download-link large-font normal-font" href = "/" target = '_blank'>Нажмите, чтобы посмотреть или скачать заявку!</a>
</block>
