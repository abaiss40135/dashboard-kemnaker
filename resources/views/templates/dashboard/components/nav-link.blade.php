<li class="{{ !request()->routeIs($route) ?: 'active' }}">
    <a
        href="{{ route($route) }}"
        class="!flex items-center space-x-2"
    >
        <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
        <span class="inline-block text-wrap break-words">{{ $title }}</span>
    </a>
</li>
