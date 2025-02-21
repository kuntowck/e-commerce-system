<div>
    <h3 class="text-lg font-semibold text-gray-700">Sales Trends</h3>
    <ul class="list-disc list-inside text-gray-600">
        <?php foreach ($salesTrends as $trend): ?>
            <li><?= $trend ?></li>
        <?php endforeach; ?>
    </ul>
</div>

<div>
    <h3 class="text-lg font-semibold text-gray-700">Inventory Levels</h3>
    <ul class="list-disc list-inside text-gray-600">
        <?php foreach ($inventoryLevels as $inventory): ?>
            <li><?= $inventory ?></li>
        <?php endforeach; ?>
    </ul>
</div>