<p class="font-semibold">
    <?= $text; ?>
</p>
<span class="text-gray-500">
    <?= $text === 'Logged in' ? $date->humanize() : $date->toLocalizedString('d MMMM yyyy'); ?>
</span>