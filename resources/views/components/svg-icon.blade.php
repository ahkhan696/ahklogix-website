{{--
    <x-svg-icon name="bolt" class="w-5 h-5 text-white">
    Renders a heroicon outline SVG using blade-ui-kit/blade-heroicons.
    Passes the name directly to the installed heroicons set (prefix: heroicon-o-*).
--}}
@props(['name' => 'code-bracket', 'class' => 'w-5 h-5'])
{!! svg('heroicon-o-' . $name, $class)->toHtml() !!}
