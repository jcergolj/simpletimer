<x-layouts.marketing
    title="Time Tracker for Freelancers, Consultants and Client Work | SimpleTimer"
    description="Track freelance and consulting work by client, project, and hourly rate, then export clear reports for invoicing."
    :canonical="route('marketing.time-tracker-for-freelancers')"
>
    <x-marketing.hero
        eyebrow="For independent work"
        heading="From focused work to a clear client report"
        intro="SimpleTimer gives freelancers and consultants a fast way to track billable time without surveillance, bloat, or a long onboarding process."
    />
    <section class="py-20 bg-[var(--color-surface)]">
        <div class="max-w-5xl mx-auto px-6 lg:px-8 grid md:grid-cols-2 gap-6">
            <x-marketing.feature title="Track by client">Keep each client’s work separate and make your reports easier to understand.</x-marketing.feature>
            <x-marketing.feature title="Set your rates">Use hourly rates for clients and projects to see the value behind your tracked time.</x-marketing.feature>
            <x-marketing.feature title="Invoice with confidence">Export the totals you need for your existing invoicing workflow.</x-marketing.feature>
            <x-marketing.feature title="Work privately">No screenshots, activity scores, or mouse tracking. Track work, not people.</x-marketing.feature>
        </div>
    </section>
    <x-marketing.cta heading="Spend less time reconstructing your work." />
</x-layouts.marketing>
