<x-layouts.marketing
    title="Project Time Tracking with Clients, Rates and Reports | SimpleTimer"
    description="Track project time by client, apply hourly rates, and export reports that show the work and value behind every project."
    :canonical="route('marketing.project-time-tracking')"
>
    <x-marketing.hero
        eyebrow="Project clarity"
        heading="See the time and value behind each project"
        intro="Connect time entries to clients and projects, set the rates that matter, and turn your work history into a report you can use."
    />
    <x-marketing.product-visuals compact />
    <section class="py-20 bg-[var(--color-surface)]">
        <div class="max-w-5xl mx-auto px-6 lg:px-8 grid md:grid-cols-2 gap-6">
            <x-marketing.feature title="Organise entries">Keep project work grouped so you can quickly understand where your time went.</x-marketing.feature>
            <x-marketing.feature title="Apply rates">Set rates per client or project and make the value of tracked time visible.</x-marketing.feature>
            <x-marketing.feature title="Filter reports">Review weekly, monthly, or custom date ranges across clients and projects.</x-marketing.feature>
            <x-marketing.feature title="Export the result">Download CSV reports and continue your billing process in the tools you prefer.</x-marketing.feature>
        </div>
    </section>
    <x-marketing.cta heading="Turn tracked time into useful project insight." />
</x-layouts.marketing>
