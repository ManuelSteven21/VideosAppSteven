<a href="{{ route('videos.index') }}"
   class="block text-sm px-1 pt-1 {{ request()->routeIs('videos.index') ? 'text-red-600 font-semibold' : 'text-gray-600 hover:text-red-600' }}">
    <span class="md:hidden">📺 Vídeos</span>
    <span class="hidden md:inline">Vídeos</span>
</a>

@can('manage-videos')
    <a href="{{ route('videos.manage.index') }}"
       class="block text-sm px-1 pt-1 {{ request()->routeIs('videos.manage.*') ? 'text-red-600 font-semibold' : 'text-gray-600 hover:text-red-600' }}">
        <span class="md:hidden">🎛️ Gestionar Vídeos</span>
        <span class="hidden md:inline">Gestionar Vídeos</span>
    </a>
@endcan

@auth
    <a href="{{ route('users.index') }}"
       class="block text-sm px-1 pt-1 {{ request()->routeIs('users.index') ? 'text-red-600 font-semibold' : 'text-gray-600 hover:text-red-600' }}">
        <span class="md:hidden">👥 Usuaris</span>
        <span class="hidden md:inline">Usuaris</span>
    </a>
@endauth

@can('manage-users')
    <a href="{{ route('users.manage.index') }}"
       class="block text-sm px-1 pt-1 {{ request()->routeIs('users.manage.*') ? 'text-red-600 font-semibold' : 'text-gray-600 hover:text-red-600' }}">
        <span class="md:hidden">🛠️ Gestionar Usuaris</span>
        <span class="hidden md:inline">Gestionar Usuaris</span>
    </a>
    <a href="{{ url('/notifications') }}"
       class="block text-sm px-1 pt-1 {{ request()->is('notifications') ? 'text-red-600 font-semibold' : 'text-gray-600 hover:text-red-600' }}">
        <span class="md:hidden">🔔 Notificacions</span>
        <span class="hidden md:inline">Notificacions</span>
    </a>
@endcan

@auth
    <a href="{{ route('series.index') }}"
       class="block text-sm px-1 pt-1 {{ request()->routeIs('series.index') ? 'text-red-600 font-semibold' : 'text-gray-600 hover:text-red-600' }}">
        <span class="md:hidden">📂 Series</span>
        <span class="hidden md:inline">Series</span>
    </a>
@endauth

@can('manage-series')
    <a href="{{ route('series.manage.index') }}"
       class="block text-sm px-1 pt-1 {{ request()->routeIs('series.manage.*') ? 'text-red-600 font-semibold' : 'text-gray-600 hover:text-red-600' }}">
        <span class="md:hidden">⚙️ Gestionar Series</span>
        <span class="hidden md:inline">Gestionar Series</span>
    </a>
@endcan
