<div class="container mx-auto p-4">
    <div class="bg-white shadow-sm rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">{title}</h1>
        <div class="mb-4">
            <h1 class="text-lg font-regular">Total Users</h1>
            <div class="text-lg font-bold text-gray-700">
                {users} Users
            </div>
            <hr class="my-2">
        </div>
        <div class="mb-4">
            <h1 class="text-lg font-regular">Total Products</h1>
            <div class="text-lg font-bold text-gray-700">
                {products} Products
            </div>
            <hr class="my-2">
        </div>
        <div class="mb-4">
            <h1 class="text-lg font-regular">Total Orders</h1>
            <div class="text-lg font-bold text-gray-700">
                {orders} Orders
            </div>
            <hr class="my-2">
        </div>
        <div class="mb-4">
            <h1 class="text-lg font-regular mb-2">Monthly Growth Percentage</h1>
            <div>
                {!productStats!}
            </div>
        </div>
    </div>
</div>