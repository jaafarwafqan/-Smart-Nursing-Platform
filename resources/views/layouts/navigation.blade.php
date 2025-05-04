@if(auth()->user()->can('manage_researches'))
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('researches.*') ? 'active' : '' }}" 
           href="{{ route('researches.index') }}">
            <i class="fas fa-book"></i> البحوث
        </a>
    </li>
@endif 