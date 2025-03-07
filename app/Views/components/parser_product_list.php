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
            <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm">
                <div>
                    <img class="rounded-t-lg" src="assets/img/nasigoreng.jpg" alt="" />
                </div>

                <div class="px-4 mt-4 flex gap-0">
                    {!badgeCell!}
                </div>

                <div class="px-4 py-2 mb-4">
                    <h3 class="text-2xl font-bold tracking-tight text-gray-900 ">Rp{price}</h3>
                    <h5 class="text-lg font-semibold tracking-tight text-gray-900 ">{name}</h5>
                    <p class="font-regular text-gray-500">{category}</p>
                    <p class="font-medium text-gray-700">description</p>

                    <p class="font-medium text-gray-700">Status: {status}</p>
                    <p class="font-medium text-gray-700">{stock} Stock ({stockStatus})</p>
                </div>
            </div>
            {/products}
        </div>
    </div>
</div>