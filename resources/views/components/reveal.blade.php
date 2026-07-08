{{--
    <x-reveal> — scroll-reveal motion primitive (§8 item 4).
    Wraps content; adds .is-visible when element enters viewport (once).
    CSS transition: opacity 0→1, translateY 10px→0, 400ms ease-out.

    Props:
      $delay  — transition-delay in ms, for staggering siblings (default 0)
      $class  — extra classes on the wrapper div

    Usage:
      <x-reveal>...</x-reveal>
      <x-reveal :delay="100">...</x-reveal>   ← 100ms stagger
--}}
@props(['delay' => 0, 'class' => ''])

<div
    x-data="{}"
    x-intersect.once="$el.classList.add('is-visible')"
    class="reveal-wrap {{ $class }}"
    @if($delay > 0) style="transition-delay: {{ $delay }}ms" @endif
>
    {{ $slot }}
</div>
