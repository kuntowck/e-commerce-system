<div class="max-w-screen-xl mx-auto p-4">
    <div class="bg-white shadow-sm rounded-md p-6">
        <h1 class="text-2xl font-bold mb-4">{title}</h1>
        {users}
        <div class="mb-4">
            <p class="text-lg font-reguler">Name: {name}</p>
            <p class="text-lg font-reguler">Email: {email}</p>
            <p class="text-lg font-reguler">Role: {role}</p>
        </div>
        {/users}
        <div class="mb-4">
            <h1 class="text-lg font-bold mb-2">Activity History</h1>
            {activityHistory}
            <div class="overflow-x-auto">
                <p class="text-lg font-reguler">Logged in: {login}</p>
                <p class="text-lg font-reguler">Updated profile: {updated}</p>
                <p class="text-lg font-reguler">Placed an order: {ordered}</p>
            </div>
            {/activityHistory}
        </div>
        <div class="mb-4">
            <h1 class="text-lg font-bold mb-2">Account Status</h1>
            <div class="overflow-x-auto">
                <p class="text-lg font-reguler">Account status: {accountStatus}</p>

            </div>
        </div>
    </div>
</div>