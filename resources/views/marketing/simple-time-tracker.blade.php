<x-layouts.marketing
    title="Simple Time Tracker for Clear, Effortless Time Tracking | SimpleTimer"
    description="A simple time tracker that helps freelancers start tracking quickly, organise work, and export useful reports."
    :canonical="route('marketing.simple-time-tracker')"
>
    <x-marketing.hero
        eyebrow="Simple by design"
        heading="A simple time tracker that stays simple"
        intro="Start a timer, assign the work to a client or project, and get back to the work. SimpleTimer keeps time tracking out of your way."
    />
    <section class="py-20 bg-[var(--color-surface)]">
        <div class="max-w-5xl mx-auto px-6 lg:px-8 grid md:grid-cols-2 gap-6">
            <x-marketing.feature title="Start in one click">Track live work instantly or add completed time manually when the day is already moving.</x-marketing.feature>
            <x-marketing.feature title="Keep work organised">Group entries by client and project so reports stay useful without complicated setup.</x-marketing.feature>
            <x-marketing.feature title="Export what matters">Export clear CSV reports for invoicing and administration without forcing you into an invoicing system.</x-marketing.feature>
            <x-marketing.feature title="Stay in control">Self-host SimpleTimer or use the managed app. Your time data remains yours.</x-marketing.feature>
        </div>
    </section>
    <x-marketing.cta />
</x-layouts.marketing>
