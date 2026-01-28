<nav class="fixed bottom-0 left-0 right-0 md:relative md:top-0 bg-slate-900 text-white z-50 shadow-lg">
    <div class="max-w-7xl mx-auto grid grid-cols-4 md:flex">
        @include('admin.partials.nav-link', ['icon' => 'home', 'label' => 'Home', 'route' => '/', 'active' => true])
        @include('admin.partials.nav-link', ['icon' => 'chat', 'label' => 'Feedback', 'route' => '#'])
        @include('admin.partials.nav-link', ['icon' => 'person', 'label' => 'Profile', 'route' => '#'])
        @include('admin.partials.nav-link', ['icon' => 'settings', 'label' => 'Settings', 'route' => '#'])
    </div>
</nav>