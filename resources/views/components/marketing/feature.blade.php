@props(['title'])

<article class="bg-[var(--color-surface)] rounded-2xl p-7 border-2 border-[var(--color-border-light)]">
    <h3 class="font-display text-xl text-[var(--color-text)]">{{ $title }}</h3>
    <div class="mt-3 text-[var(--color-text-secondary)] leading-relaxed">{{ $slot }}</div>
</article>
