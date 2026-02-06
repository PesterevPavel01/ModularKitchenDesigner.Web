   <!-- Обертка для прокрутки -->
<div class="overflow-auto h-100">
    <ul class="events-section ...">
        <!-- Ваш цикл с событиями -->
        <?php foreach($Result->data['items'] as $item): ?>
        <!-- ... -->
        <?php endforeach; ?>
    </ul>
</div>