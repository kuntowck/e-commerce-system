<div class="max-w-screen-xl mx-auto p-4 mb-10">
    <div class="bg-white shadow-sm rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">{title}</h1>
        <form method="get" class="mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="col-span-1">
                    <input type="text" name="search" class="form-control mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Search product...">
                </div>
                <div class="col-span-1">
                    <select name="category" class="form-select mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="All">All Categories</option>
                        <option value="Rice">Rice</option>
                        <option value="Sate">Sate</option>
                        <option value="Snack">Snack</option>
                    </select>
                </div>
                <div class="col-span-1">
                    <button type="submit" class="w-full px-4 py-2 bg-blue-500 text-white font-semibold text-sm rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Apply Filters</button>
                </div>
            </div>
        </form>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {products}
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="p-4">
                    <h2 class="text-lg font-semibold text-gray-700 mb-2">
                        {name} {!badgeCell!}
                    </h2>
                    <p class="text-lg font-semibold text-gray-700 mb-2">Rp{price}</p>
                    <p class="text-gray-600">{stock} Stock ({stockStatus})</p>
                    <p class="text-gray-600">Status: {status}</p>
                    <div class="mt-2">
                        <span class="text-md font-semibold text-gray-700">Categories:</span>
                        {category}
                    </div>
                </div>
            </div>
            {/products}
        </div>
    </div>
</div>