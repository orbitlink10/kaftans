<svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true">
@switch($icon)
@case('search')<circle cx="10.5" cy="10.5" r="6.8"/><path d="m16 16 5 5"/>@break
@case('user')<circle cx="12" cy="7" r="3.7"/><path d="M4 22v-3a8 8 0 0 1 16 0v3"/>@break
@case('heart')<path d="M12 21 3 12C-3 4 7-1 12 6c5-7 15-2 9 6Z"/>@break
@default<path d="M4 7h16l1 15H3L4 7Z"/><path d="M8 8V5a4 4 0 0 1 8 0v3"/>
@endswitch</svg>
