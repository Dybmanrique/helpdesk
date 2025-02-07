<div class="sidebar sidebar-dark sidebar-fixed border-end" id="sidebar">
    <div class="sidebar-header border-bottom">
        <div class="sidebar-brand">
            <svg class="sidebar-brand-full" width="88" height="32" alt="CoreUI Logo">
                <use xlink:href="{{ asset('coreui/assets/brand/coreui.svg#full') }}"></use>
            </svg>
            <svg class="sidebar-brand-narrow" width="32" height="32" alt="CoreUI Logo">
                <use xlink:href="{{ asset('coreui/assets/brand/coreui.svg#signet') }}"></use>
            </svg>
        </div>
        <button class="btn-close d-lg-none" type="button" data-coreui-theme="dark" aria-label="Close"
            onclick="coreui.Sidebar.getInstance(document.querySelector(&quot;#sidebar&quot;)).toggle()"></button>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        @if (!Auth::guest())
            @foreach (config('dashboard.sidebar') as $item)
                @if (isset($item['title']))
                    @if (!isset($item['can']) || collect($item['can'])->some(fn($permission) => auth()->user()->can($permission)))
                        <!-- Título de sección -->
                        <li class="nav-title">{{ $item['title'] }}</li>
                    @endif
                @elseif (isset($item['submenu']))
                    @if (!isset($item['can']) || collect($item['can'])->some(fn($permission) => auth()->user()->can($permission)))
                        <!-- Menú desplegable -->
                        <li class="nav-group">
                            <a class="nav-link nav-group-toggle" href="#">
                                <div class="nav-icon">
                                    <i class="{{ $item['icon'] }}"></i>
                                </div>
                                {{ $item['text'] }}
                            </a>
                            <ul class="nav-group-items">
                                @foreach ($item['submenu'] as $subitem)
                                    @if (!isset($subitem['can']) || collect($subitem['can'])->some(fn($permission) => auth()->user()->can($permission)))
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->is($subitem['active']) ? 'active' : '' }}"
                                                href="{{ isset($subitem['route']) ? route($subitem['route']) : url($subitem['url']) }}">
                                                <span class="nav-icon">
                                                    <span class="nav-icon-bullet"></span>
                                                </span>
                                                {{ $subitem['text'] }}
                                                @if (isset($subitem['badge']))
                                                    <span
                                                        class="badge {{ $subitem['badge']['class'] }}">{{ $subitem['badge']['text'] }}</span>
                                                @endif
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @else
                    @if (!isset($item['can']) || collect($item['can'])->some(fn($permission) => auth()->user()->can($permission)))
                        <!-- Enlace de menú simple -->
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is($item['active']) ? 'active' : '' }}"
                                href="{{ isset($item['route']) ? route($item['route']) : url($item['url']) }}">
                                <div class="nav-icon">
                                    <i class="{{ $item['icon'] }}"></i>
                                </div>
                                {{ $item['text'] }}
                            </a>
                        </li>
                    @endif
                @endif
            @endforeach
        @endif
    </ul>
    <div class="sidebar-footer border-top d-none d-md-flex">
        <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
    </div>
</div>
