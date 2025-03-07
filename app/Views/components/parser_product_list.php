<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    {products}
    <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm">
        <div>
            <img class="rounded-t-lg" src="{image_path}" alt="{image_path}" />
        </div>

        <div class="px-4 mt-4 flex gap-0">
        {!badgeNew!}
            {!badgeSale!}
        </div>

        <div class="px-4 py-2 mb-4">
            <h3 class="text-2xl font-bold tracking-tight text-gray-900 ">{price}</h3>
            <h5 class="text-lg font-semibold tracking-tight text-gray-900 ">{name}</h5>
            <p class="font-regular text-gray-500">{category}</p>
            <p class="font-medium text-gray-700">{description}</p>
            <p class="font-medium text-gray-700">{stock} Stock ({status})</p>
        </div>
    </div>
    {/products}
</div>