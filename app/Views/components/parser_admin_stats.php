<div class="bg-white shadow-sm rounded-lg p-8">
    <h1 class="text-2xl font-bold mb-4">{title}</h1>
    <div class="flex gap-16">
        <div>
            {users}
            <div class="flex gap-8">
                <div class="mb-4">
                    <h1 class="text-lg font-semibold">Total Users</h1>
                    <div class="text-lg font-regular text-gray-600">
                        {total_users} Users
                    </div>
                    <hr class="my-2">
                </div>
                <div class="mb-4">
                    <h1 class="text-lg font-semibold">Active Users</h1>
                    <div class="text-lg font-regular text-gray-600">
                        {active_users} Users
                    </div>
                    <hr class="my-2">
                </div>
                <div class="mb-4">
                    <h1 class="text-lg font-semibold">New Users this Month</h1>
                    <div class="text-lg font-regular text-gray-600">
                        {new_users_this_month} Users
                    </div>
                    <hr class="my-2">
                </div>
            </div>
            {/users}
            {products}
            <div class="flex gap-8">
                <div class="mb-4">
                    <h1 class="text-lg font-semibold">Total Products</h1>
                    <div class="text-lg font-regular text-gray-600">
                        {total_products} Products
                    </div>
                    <hr class="my-2">
                </div>
                <div class="mb-4">
                    <h1 class="text-lg font-semibold">Available Products</h1>
                    <div class="text-lg font-regular text-gray-600">
                        {available_products} Products
                    </div>
                    <hr class="my-2">
                </div>
                <div class="mb-4">
                    <h1 class="text-lg font-semibold">Out of Stock</h1>
                    <div class="text-lg font-regular text-gray-600">
                        {out_of_stock} Products
                    </div>
                    <hr class="my-2">
                </div>
            </div>
            {/products}
            <div class="mb-4">
                <h1 class="text-lg font-semibold">Total Orders</h1>
                <div class="text-md font-regular text-gray-600">
                    {orders} Orders
                </div>
                <hr class="my-2">
            </div>

        </div>
        <div class="mb-4">
            <h1 class="text-lg font-semibold mb-2">Monthly Growth Percentage</h1>
            <div>
                {!productStats!}
            </div>
        </div>
    </div>
</div>