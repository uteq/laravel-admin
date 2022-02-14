<x-move-dropdown align="left" width="48" orientation="{{ ($orientation ?? 'right') ? 'right' : 'left' }}">
    <x-slot name="trigger">
        <button {{ $attributes->merge(['class' => 'flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out']) }}>
            @if (Auth::user())
                @if (Auth::user()->profile_photo_url)
                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                @elseif (Auth::user()->name)
                    <div class="p-1.5">
                        {{ Auth::user()->initials ?: Auth::user()->name }}
                    </div>
                @endif
            @endif
        </button>
    </x-slot>

    <!-- Account Management -->
    <div class="block px-4 py-2 text-xs text-gray-400">
        @lang('Account Management')
    </div>

    <x-move-dropdown-link href="/user/profile">
        @lang('Profile')
    </x-move-dropdown-link>

    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
        <x-move-dropdown-link href="/user/api-tokens">
            @lang('API Tokens')
        </x-move-dropdown-link>
    @endif

    <div class="border-t border-gray-100"></div>

    <!-- Team Management -->
    @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
        <div class="block px-4 py-2 text-xs text-gray-400">
            @lang('Manage Team')
        </div>

        <!-- Team Settings -->
        <x-move-dropdown-link href="/teams/{{ optional(Auth::user())->currentTeam->id }}">
            @lang('Team Settings')
        </x-move-dropdown-link>

        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
            <x-move-dropdown-link href="/teams/create">
                @lang('Form New Team')
            </x-move-dropdown-link>
        @endcan

        <div class="border-t border-gray-100"></div>

        <!-- Team Switcher -->
        <div class="block px-4 py-2 text-xs text-gray-400">
            @lang('Switch Teams')
        </div>

        @foreach (Auth::user()->allTeams() as $team)
            <x-move-switchable-team :team="$team" />
        @endforeach

        <div class="border-t border-gray-100"></div>
    @endif

    <!-- Authentication -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <x-move-dropdown-link href="{{ route('logout') }}"
                             onclick="event.preventDefault();
                             this.closest('form').submit();">
            @lang('Logout')
        </x-move-dropdown-link>
    </form>
</x-move-dropdown>
