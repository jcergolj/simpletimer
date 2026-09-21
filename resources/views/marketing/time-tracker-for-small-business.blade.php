<x-layouts.marketing
    title="Simple Time Tracker for Small Business Project Work | SimpleTimer"
    description="A straightforward small business time tracker for organising project work, clients, hourly rates, and reports."
    :canonical="route('marketing.time-tracker-for-small-business')"
>
    <x-marketing.hero
        eyebrow="For small businesses"
        heading="Keep project time clear without enterprise complexity"
        intro="SimpleTimer helps small teams and owner-led businesses understand where project time goes and what work is ready to invoice."
    />
    <x-marketing.product-visuals compact />
    <section class="py-20 bg-[var(--color-surface)]">
        <div class="max-w-5xl mx-auto px-6 lg:px-8 grid md:grid-cols-2 gap-6">
            <x-marketing.feature title="See project time">Keep project entries in one place and understand the effort behind each deliverable.</x-marketing.feature>
            <x-marketing.feature title="Manage clients simply">Use the client and project structure you already understand, without an enterprise hierarchy.</x-marketing.feature>
            <x-marketing.feature title="Prepare reports">Create useful weekly, monthly, or custom reports for billing and review.</x-marketing.feature>
            <x-marketing.feature title="Choose your hosting">Use the managed service or keep your data on infrastructure you control.</x-marketing.feature>
        </div>
    </section>
    <x-marketing.cta heading="Make project time easier to see." />
</x-layouts.marketing>
