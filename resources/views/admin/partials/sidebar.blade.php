<!-- Overlay mobile -->
<div id="sidebar-overlay" onclick="toggleSidebar()"
    class="fixed inset-0 z-20 bg-black/40 backdrop-blur-sm hidden lg:hidden transition-all duration-300">
</div>


<!-- Sidebar -->
<aside id="sidebar" class="fixed inset-y-0 left-0 z-30 w-66 bg-white text-gray-700
           transform -translate-x-full transition-transform duration-300 ease-in-out
           lg:translate-x-0 lg:static lg:inset-0 flex flex-col h-screen border-r">

    <!-- Logo -->
    @include('admin.partials.sidebar.logo')

    <!-- Menu -->
    <nav class="flex-1 overflow-y-auto py-4">
        <ul class="space-y-1">

            <!-- Dashboard -->
            @include('admin.partials.sidebar.dashboard')

            <!-- Categories -->
            @include('admin.partials.sidebar.categories')

            <!-- Products -->
            @include('admin.partials.sidebar.products')

            <!-- Nail Categories -->
            @include('admin.partials.sidebar.nail-categories')

            <!-- Nails -->
            @include('admin.partials.sidebar.nails')

            <!-- Banners -->
            @include('admin.partials.sidebar.banners')

            <!-- Blog -->
            @include('admin.partials.sidebar.posts')

            <!-- Booking -->
            @include('admin.partials.sidebar.booking')

            <!-- Admin -->
            @include('admin.partials.sidebar.admins')

            <!-- Permission -->
            @include('admin.partials.sidebar.permissions')

            <!-- Settings -->
            @include('admin.partials.sidebar.settings')

        </ul>
    </nav>

    <!-- Logout -->
    @include('admin.partials.sidebar.logout')

</aside>


@include('admin.partials.sidebar.script')