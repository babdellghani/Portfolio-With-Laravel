@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-1 bg-white'])

@php
    switch ($align) {
        case 'left':
            $alignmentClasses = 'start-0';
            break;
        case 'top':
            $alignmentClasses = 'top-0 start-50 translate-middle-x';
            break;
        case 'right':
        default:
            $alignmentClasses = 'end-0';
            break;
    }

    switch ($width) {
        case '48':
            $width = 'w-auto'; // Bootstrap doesn't have a direct w-48 equivalent
            break;
    }
@endphp

<div class="position-relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
    <div @click="open = ! open">
        {{ $trigger }}
    </div>

    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
        class="position-absolute {{ $alignmentClasses }} mt-2 {{ $width }} rounded shadow-lg z-3"
        style="display: none;" @click="open = false">
        <div class="rounded border {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>
