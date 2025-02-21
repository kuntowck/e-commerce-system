<div class="max-w-screen-xl mx-auto p-4">
    <div class="bg-white shadow-sm rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">{title}</h1>
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    {products}
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{id}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{name} {!badgeCell!}</td>
                        <td class="px-6 py-4 whitespace-nowrap">Rp{price}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{stock} ({stockStatus})</td>
                        {categories}
                        <td class="px-6 py-4 whitespace-nowrap">
                            {0} | {1}
                        </td>
                        {/categories}
                        <td class="px-6 py-4 whitespace-nowrap">{status}</td>
                    </tr>
                    {/products}
                </tbody>
            </table>
        </div>
    </div>
</div>