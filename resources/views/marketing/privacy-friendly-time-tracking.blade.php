<x-layouts.marketing
    title="Privacy-Friendly Time Tracking Without Surveillance | SimpleTimer"
    description="Track time without screenshots, activity monitoring, or employee surveillance. SimpleTimer puts privacy and control first."
    :canonical="route('marketing.privacy-friendly-time-tracking')"
>
    <x-marketing.hero
        eyebrow="Privacy first"
        heading="Time tracking without surveillance"
        intro="SimpleTimer records the time you choose to track. It does not watch your screen, score your activity, or turn work into a monitoring exercise."
    />
    <section class="py-20 bg-[var(--color-surface)]">
        <div class="max-w-5xl mx-auto px-6 lg:px-8 grid md:grid-cols-2 gap-6">
            <x-marketing.feature title="No screenshots">Your work stays yours. SimpleTimer does not capture your screen or inspect your applications.</x-marketing.feature>
            <x-marketing.feature title="No activity scores">Track time as a useful record, not as a proxy for whether someone looks busy.</x-marketing.feature>
            <x-marketing.feature title="Self-host if you want">Run SimpleTimer on your own server and keep direct control over your data.</x-marketing.feature>
            <x-marketing.feature title="Export anytime">Your reports are portable and ready for the tools you already use.</x-marketing.feature>
        </div>
    </section>
    <x-marketing.cta heading="Track time, not people." />
</x-layouts.marketing>
