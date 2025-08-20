<div class="w-1/4  min-h-screen p-10">
    {{-- <h2 class="text-lg font-bold mb-4">Dashboard</h2> --}}
    <ul>
        <li class="mb-2">
            <a href="#" class="block p-2 dark:text-white">
                Dashboard
            </a>
        </li>
        <li class="mb-2">
            <a href="{{ route('dashboard.account') }}"
                class="block p-2   dark:text-white  {{ request()->routeIs('dashboard.account') ? 'text-primary' : '' }}">
                Account
            </a>
        </li>
        <li class="mb-2">
            <a href="{{ route('dashboard.orders') }}"
                class="block p-2   dark:text-white {{ request()->routeIs('dashboard.orders') ? 'text-primary' : '' }}">
                Orders
            </a>
        </li>
        <li class="mb-2">
            <a href="{{ route('dashboard.reviews') }}"
                class="block p-2  dark:text-white  {{ request()->routeIs('dashboard.reviews') ? 'text-primary' : '' }}">
                Reviews
            </a>
        </li>
    </ul>
</div>
