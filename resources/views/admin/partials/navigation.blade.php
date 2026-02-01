<nav class="fixed bottom-0 left-0 right-0 md:sticky md:top-14 z-50 
            bg-slate-900/95 backdrop-blur-md 
            border-t border-white/10 md:border-t-0 md:border-b md:border-white/5 
            shadow-[0_-4px_20px_-5px_rgba(0,0,0,0.3)] 
            transition-all duration-300">
            
    <div class="max-w-7xl grid grid-cols-5 md:flex md:justify-left">
        @include('admin.partials.nav-link', [
            'icon'   => 'home', 
            'label'  => 'Home', 
            'route'  => url('/'), 
            'active' => request()->is('/')
        ])

        @include('admin.partials.nav-link', [
            'icon'   => 'dashboard', 
            'label'  => 'Dashboard', 
            'route'  => route('admin.dashboard'), 
            'active' => request()->routeIs('admin.dashboard')
        ])



        @include('admin.partials.nav-link', [
            'icon'   => 'chat', 
            'label'  => 'HOSTEL', 
            'route'  => route('admin.navbar.hostel'), 
            'active' => request()->routeIs('admin.navbar.hostel')
        ])

        @include('admin.partials.nav-link', [
            'icon'   => 'person', 
            'label'  => 'REPORT', 
            'route'  => route('admin.navbar.report'), 
            'active' => request()->routeIs('admin.navbar.report')
        ])

        @include('admin.partials.nav-link', [
            'icon'   => 'settings', 
            'label'  => 'Checkin/Out', 
            'route'  => route('admin.navbar.checkout'), 
            'active' => request()->routeIs('admin.navbar.checkout')
        ])
        
    </div>
</nav>