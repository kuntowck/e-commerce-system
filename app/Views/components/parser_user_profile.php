<div class="bg-white shadow-sm rounded-md p-6">
    <h1 class="text-2xl font-bold mb-4">{title}</h1>
    <div class="flex gap-16">
        {user}
        <div class="mb-4">
            <h1 class="text-lg font-bold mb-2">Profile</h1>
            <div>
                <span class="font-semibold">Name: </span>
                <span class="font-regular text-gray-500">{full_name}</span>
            </div>
            <div>
                <span class="font-semibold">Email: </span>
                <span class="text-gray-500">{email}</span>
            </div>
            <div>
                <span class="font-semibold">Role: </span>
                <span class="text-gray-500">{!role!}</span>
            </div>
        </div>
        {/user}
        <div class="mb-4">
            <h1 class="text-lg font-bold mb-2">Activity History</h1>
            {userProfileCell}
            <div class="overflow-x-auto">
                <div class="mb-2">{!login!}</div>
                <div class="mb-2">{!updated!}</div>
                <div class="mb-2">{!created!}</div>
            </div>
            {/userProfileCell}
        </div>
        <div class="mb-4">
            <h1 class="text-lg font-bold mb-2">Account Status</h1>
            <div class="overflow-x-auto">
                <p class="font-semibold">Account status:
                    <span class="text-gray-500">{!accountStatus!}</span>
                </p>
            </div>
        </div>
    </div>
</div>