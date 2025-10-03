<nav x-data="{ open: false }" class="bg-white/98 backdrop-blur-lg shadow-xl border-b border-rose-100/50 sticky top-0 z-50">
    <!-- Professional Salon Navigation -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-24">
            <!-- Elegant Logo Section -->
            <div class="flex items-center space-x-4 group">
                <div class="relative">
                    <a href="{{ route('dashboard') }}" class="block">
                        <img src="{{ asset('images/Logo.jpg') }}" alt="Luxe Hair Studio Logo" 
                             class="h-12 w-auto rounded-lg shadow-md group-hover:shadow-lg transition-all duration-300">
                    </a>
                    <div class="absolute -inset-1 bg-gradient-to-r from-rose-500 to-pink-500 rounded-lg blur opacity-20 group-hover:opacity-40 transition duration-300"></div>
                </div>
                <div class="hidden sm:block">
                    <a href="{{ route('dashboard') }}" class="block">
                        <h1 class="text-2xl font-bold text-black font-serif tracking-wide">
                            Luxe Hair Studio
                        </h1>
                        <p class="text-xs text-black font-medium tracking-widest uppercase">Professional Hair Care</p>
                    </a>
                </div>
            </div>

            <!-- Professional Navigation Menu -->
            <div class="hidden md:flex items-center space-x-1">
                <a href="{{ route('dashboard') }}" 
                   class="relative px-6 py-3 text-sm font-medium text-gray-700 hover:text-rose-600 transition-all duration-300 group {{ request()->routeIs('dashboard') ? 'text-rose-600' : '' }}">
                    <span class="relative z-10 tracking-wide">DASHBOARD</span>
                    <div class="absolute inset-0 bg-gradient-to-r from-rose-50 to-pink-50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 {{ request()->routeIs('dashboard') ? 'opacity-100' : '' }}"></div>
                    @if(request()->routeIs('dashboard'))
                        <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-8 h-0.5 bg-gradient-to-r from-rose-500 to-pink-500 rounded-full"></div>
                    @endif
                </a>
                
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.customers') }}" 
                       class="relative px-6 py-3 text-sm font-medium text-gray-700 hover:text-rose-600 transition-all duration-300 group {{ request()->routeIs('admin.customers') ? 'text-rose-600' : '' }}">
                        <span class="relative z-10 tracking-wide">CUSTOMERS</span>
                        <div class="absolute inset-0 bg-gradient-to-r from-rose-50 to-pink-50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 {{ request()->routeIs('admin.customers') ? 'opacity-100' : '' }}"></div>
                        @if(request()->routeIs('admin.customers'))
                            <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-8 h-0.5 bg-gradient-to-r from-rose-500 to-pink-500 rounded-full"></div>
                        @endif
                    </a>
                    <a href="{{ route('admin.services') }}" 
                       class="relative px-6 py-3 text-sm font-medium text-gray-700 hover:text-rose-600 transition-all duration-300 group {{ request()->routeIs('admin.services') ? 'text-rose-600' : '' }}">
                        <span class="relative z-10 tracking-wide">SERVICES</span>
                        <div class="absolute inset-0 bg-gradient-to-r from-rose-50 to-pink-50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 {{ request()->routeIs('admin.services') ? 'opacity-100' : '' }}"></div>
                        @if(request()->routeIs('admin.services'))
                            <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-8 h-0.5 bg-gradient-to-r from-rose-500 to-pink-500 rounded-full"></div>
                        @endif
                    </a>
                @endif
                
                <!-- Back to Website Button -->
                <div class="ml-6">
                    <a href="{{ route('home') }}" 
                       class="relative inline-flex items-center px-8 py-3 bg-gradient-to-r from-rose-500 via-pink-500 to-rose-600 text-white font-semibold text-sm tracking-wide rounded-full shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 group overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-rose-600 via-pink-600 to-rose-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <span class="relative z-10 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m0 0V11a1 1 0 011-1h2a1 1 0 011 1v10m0 0h3a1 1 0 001-1V10M9 21h6"/>
                            </svg>
                            BACK TO WEBSITE
                        </span>
                    </a>
                </div>
            </div>

            <!-- Elegant User Dropdown -->
            <div class="flex items-center justify-end space-x-6">
                <!-- Teams Dropdown (if enabled) -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="flex items-center space-x-2 px-4 py-2 bg-gradient-to-r from-gray-50 to-rose-50 hover:from-rose-50 hover:to-pink-50 rounded-full border border-rose-100 shadow-sm hover:shadow-md transition-all duration-300 group focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-opacity-50">
                            <span class="text-sm font-semibold text-gray-900">{{ Auth::user()->currentTeam->name }}</span>
                            <svg class="w-4 h-4 text-gray-500 transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <!-- Team Dropdown Menu -->
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 transform scale-95 translate-y-2"
                             x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100 transform scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 transform scale-95 translate-y-2"
                             class="absolute right-0 mt-4 w-64 bg-white rounded-2xl shadow-2xl border border-rose-100 py-3 z-50 backdrop-blur-sm">
                            
                            <div class="px-6 py-4 border-b border-gray-100">
                                <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Manage Team</p>
                            </div>

                            <div class="py-2">
                                <a href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" 
                                   class="flex items-center px-6 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-rose-50 hover:to-pink-50 hover:text-rose-600 transition-all duration-200">
                                    <svg class="w-5 h-5 mr-3 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span class="font-medium">Team Settings</span>
                                </a>

                                @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                    <a href="{{ route('teams.create') }}" 
                                       class="flex items-center px-6 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-rose-50 hover:to-pink-50 hover:text-rose-600 transition-all duration-200">
                                        <svg class="w-5 h-5 mr-3 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        <span class="font-medium">Create New Team</span>
                                    </a>
                                @endcan

                                @if (Auth::user()->allTeams()->count() > 1)
                                    <div class="border-t border-gray-100 mt-2 pt-2">
                                        <div class="px-6 py-2">
                                            <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Switch Teams</p>
                                        </div>
                                        @foreach (Auth::user()->allTeams() as $team)
                                            <x-switchable-team :team="$team" />
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- User Settings Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" 
                            class="flex items-center space-x-3 px-4 py-2 bg-gradient-to-r from-gray-50 to-rose-50 hover:from-rose-50 hover:to-pink-50 rounded-full border border-rose-100 shadow-sm hover:shadow-md transition-all duration-300 group focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-opacity-50">
                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            <img class="w-8 h-8 rounded-full object-cover border-2 border-white shadow-sm group-hover:shadow-md transition-all duration-300" 
                                 src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">
                        @else
                            <div class="w-8 h-8 bg-gradient-to-br from-rose-500 to-pink-600 rounded-full flex items-center justify-center shadow-sm group-hover:shadow-md transition-all duration-300">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        @endif
                        <div class="hidden sm:block text-left">
                            <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500 capitalize">{{ Auth::user()->role ?? 'Member' }}</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-500 transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <!-- User Dropdown Menu -->
                    <div x-show="open" 
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform scale-95 translate-y-2"
                         x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 transform scale-100 translate-y-0"
                         x-transition:leave-end="opacity-0 transform scale-95 translate-y-2"
                         class="absolute right-0 mt-4 w-64 bg-white rounded-2xl shadow-2xl border border-rose-100 py-3 z-50 backdrop-blur-sm">
                        
                        <div class="px-6 py-4 border-b border-gray-100">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-gradient-to-br from-rose-500 to-pink-600 rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold text-lg">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                                    <p class="text-sm text-gray-500 truncate">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="py-2">
                            <a href="{{ route('profile.show') }}" 
                               class="flex items-center px-6 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-rose-50 hover:to-pink-50 hover:text-rose-600 transition-all duration-200">
                                <svg class="w-5 h-5 mr-3 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="font-medium">Profile Settings</span>
                            </a>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <a href="{{ route('api-tokens.index') }}" 
                                   class="flex items-center px-6 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-rose-50 hover:to-pink-50 hover:text-rose-600 transition-all duration-200">
                                    <svg class="w-5 h-5 mr-3 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                    </svg>
                                    <span class="font-medium">API Tokens</span>
                                </a>
                            @endif
                        </div>

                        <div class="border-t border-gray-100 pt-2">
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <button type="submit" @click.prevent="$root.submit();"
                                        class="w-full flex items-center px-6 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-red-50 hover:to-rose-50 hover:text-red-600 transition-all duration-200 text-left">
                                    <svg class="w-5 h-5 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    <span class="font-medium">Sign Out</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Elegant Mobile Menu Button -->
                <div class="md:hidden">
                    <button @click="open = ! open" 
                            class="inline-flex items-center justify-center p-3 rounded-full text-gray-600 hover:text-rose-600 hover:bg-gradient-to-r hover:from-rose-50 hover:to-pink-50 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-opacity-50 transition-all duration-300 border border-gray-200 hover:border-rose-200">
                        <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden border-t border-gray-100 py-4">
        <div class="space-y-2">
            <a href="{{ route('dashboard') }}" class="block px-4 py-3 text-base font-semibold text-gray-700 hover:bg-rose-50 hover:text-rose-600 rounded-lg transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'text-rose-600 bg-rose-50' : '' }}">Dashboard</a>
            
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.customers') }}" class="block px-4 py-3 text-base font-semibold text-gray-700 hover:bg-rose-50 hover:text-rose-600 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.customers') ? 'text-rose-600 bg-rose-50' : '' }}">Customers</a>
                <a href="{{ route('admin.bookings.index') }}" class="block px-4 py-3 text-base font-semibold text-gray-700 hover:bg-rose-50 hover:text-rose-600 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.bookings.index') ? 'text-rose-600 bg-rose-50' : '' }}">Bookings</a>
                <a href="{{ route('admin.services') }}" class="block px-4 py-3 text-base font-semibold text-gray-700 hover:bg-rose-50 hover:text-rose-600 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.services') ? 'text-rose-600 bg-rose-50' : '' }}">Services</a>
            @endif
            
            <a href="{{ route('home') }}" class="block px-4 py-3 text-base font-semibold text-gray-700 hover:bg-rose-50 hover:text-rose-600 rounded-lg transition-colors duration-200">Back to Website</a>
        </div>

        <!-- Mobile User Section -->
        <div class="border-t border-gray-100 pt-4 mt-4">
            <div class="px-4 py-2">
                <div class="flex items-center space-x-3 mb-3">
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                        <img class="w-10 h-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">
                    @else
                        <div class="w-10 h-10 bg-gradient-to-br from-rose-500 to-pink-600 rounded-full flex items-center justify-center shadow-sm">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                    @endif
                    <div>
                        <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                    </div>
                </div>
            </div>

            <a href="{{ route('profile.show') }}" class="flex items-center px-4 py-3 text-base font-semibold text-gray-700 hover:bg-rose-50 hover:text-rose-600 rounded-lg transition-colors duration-200 {{ request()->routeIs('profile.show') ? 'text-rose-600 bg-rose-50' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Profile
            </a>

            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                <a href="{{ route('api-tokens.index') }}" class="flex items-center px-4 py-3 text-base font-semibold text-gray-700 hover:bg-rose-50 hover:text-rose-600 rounded-lg transition-colors duration-200 {{ request()->routeIs('api-tokens.index') ? 'text-rose-600 bg-rose-50' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                    API Tokens
                </a>
            @endif

            <form method="POST" action="{{ route('logout') }}" x-data>
                @csrf
                <button type="submit" @click.prevent="$root.submit();" class="w-full flex items-center px-4 py-3 text-base font-semibold text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg transition-colors duration-200 text-left">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Logout
                </button>
            </form>

            <!-- Team Management (Mobile) -->
            @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                <div class="border-t border-gray-200 mt-4 pt-4">
                    <div class="px-4 py-2">
                        <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Manage Team</p>
                    </div>

                    <a href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" class="flex items-center px-4 py-3 text-base font-semibold text-gray-700 hover:bg-rose-50 hover:text-rose-600 rounded-lg transition-colors duration-200 {{ request()->routeIs('teams.show') ? 'text-rose-600 bg-rose-50' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Team Settings
                    </a>

                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <a href="{{ route('teams.create') }}" class="flex items-center px-4 py-3 text-base font-semibold text-gray-700 hover:bg-rose-50 hover:text-rose-600 rounded-lg transition-colors duration-200 {{ request()->routeIs('teams.create') ? 'text-rose-600 bg-rose-50' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Create New Team
                        </a>
                    @endcan

                    @if (Auth::user()->allTeams()->count() > 1)
                        <div class="border-t border-gray-200 mt-2 pt-2">
                            <div class="px-4 py-2">
                                <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Switch Teams</p>
                            </div>
                            @foreach (Auth::user()->allTeams() as $team)
                                <x-switchable-team :team="$team" component="responsive-nav-link" />
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</nav>
