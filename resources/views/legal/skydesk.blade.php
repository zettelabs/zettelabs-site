@extends('layouts.site')

{{-- Same text as ~/focusflight/docs/privacy-policy.html; keep the two in step. --}}
@section('title', 'Skydesk Privacy Policy')
@section('description', 'Privacy policy for Skydesk, an offline focus timer for Android by Zettelabs.')

@section('content')

    <div class="mx-auto max-w-3xl px-6 py-16 md:py-20">
        <span class="inline-flex items-center gap-2 rounded-full border border-line bg-accent-soft px-3 py-1 font-mono text-xs uppercase tracking-wider text-accent-deep">
            Privacy Policy
        </span>
        <h1 class="mt-5 text-3xl font-semibold text-ink md:text-4xl">Skydesk Privacy Policy</h1>
        <p class="mt-4 text-sm text-ink-dim">App: Skydesk (com.zettelabs.skydesk) · Developer: Zettelabs · Effective: 11 November 2026 · Applies to version 0.1.0 and later</p>

        <p class="mt-8 text-ink-dim">This policy explains what information Skydesk handles, why, and the choices you have. Skydesk does not require an account and does not ask for your name, email address, phone number, contacts or location.</p>

        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">1. Your flights stay on your device</h2>
            <p class="mt-3 text-ink-dim">Skydesk is a focus timer: you pick two airports from a list built into the app and the flight time becomes your focus session. Your flights, logbook, passport stamps, streaks and settings are stored only in the app's private storage on your phone and are <strong class="text-ink">never uploaded</strong> to us or to any third party. The map, the airport list and the cabin sound are part of the app and work without an internet connection.</p>
            <p class="mt-3 text-ink-dim">When you choose <em>Share</em>, a short text about your flight is handed to the app you pick (for example a messaging app). From that point the receiving app's policy applies.</p>
        </section>

        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">2. Permissions</h2>
            <div class="mt-3 overflow-x-auto"><table class="w-full border-collapse text-left text-sm text-ink-dim">
            <thead><tr class="border-b border-line text-ink"><th class="p-2 font-semibold">Permission</th><th class="p-2 font-semibold">Why</th></tr></thead><tbody class="[&_td]:border-b [&_td]:border-line [&_td]:p-2 [&_td]:align-top">
            <tr><td>Notifications</td><td>To show the countdown while a flight is running and to tell you when you land.</td></tr>
            <tr><td>Foreground service, exact alarms</td><td>To keep the timer running with the screen off and to land the flight on time, even if the app is closed.</td></tr>
            <tr><td>Do Not Disturb access (optional)</td><td>Only if you switch on Do Not Disturb for a flight. Skydesk turns it on at take-off and restores your previous setting at landing.</td></tr>
            <tr><td>Internet</td><td>To load ads, app configuration and crash reports (see below). Your flights are never sent.</td></tr>
            </tbody></table></div>
        </section>

        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">3. Information collected by third-party services</h2>
            <p class="mt-3 text-ink-dim">Skydesk is free and supported by ads. There are no ads during a flight. It uses the following Google services, which may collect information automatically from your device:</p>
            <div class="mt-3 overflow-x-auto"><table class="w-full border-collapse text-left text-sm text-ink-dim">
            <thead><tr class="border-b border-line text-ink"><th class="p-2 font-semibold">Service</th><th class="p-2 font-semibold">Purpose</th><th class="p-2 font-semibold">Data it may collect</th></tr></thead><tbody class="[&_td]:border-b [&_td]:border-line [&_td]:p-2 [&_td]:align-top">
            <tr><td>Google AdMob</td><td>Showing ads (native and interstitial ads after landing, and an optional rewarded ad)</td><td>Advertising ID, IP address, device and app information, ad interactions</td></tr>
            <tr><td>Google User Messaging Platform</td><td>Asking for and storing your ad consent where required by law</td><td>Your consent choices, device information</td></tr>
            <tr><td>Firebase Analytics</td><td>Understanding how the app is used so we can improve it</td><td>App usage events, app instance ID, device and app information, approximate location derived from IP</td></tr>
            <tr><td>Firebase Crashlytics</td><td>Diagnosing crashes</td><td>Crash logs, device state at the time of the crash, app instance ID</td></tr>
            <tr><td>Firebase Remote Config</td><td>Adjusting app settings, such as ad frequency, without an update</td><td>App instance ID, device and app information</td></tr>
            </tbody></table></div>
            <p class="mt-3 text-ink-dim">These services are governed by their own policies: <a class="text-accent underline underline-offset-2 hover:text-accent-deep" href="https://policies.google.com/privacy">Google Privacy Policy</a>, <a class="text-accent underline underline-offset-2 hover:text-accent-deep" href="https://policies.google.com/technologies/partner-sites">How Google uses information from apps that use its services</a>, and <a class="text-accent underline underline-offset-2 hover:text-accent-deep" href="https://firebase.google.com/support/privacy">Firebase privacy information</a>.</p>
            <p class="mt-3 text-ink-dim">We do not sell your personal information. Data is transmitted over encrypted connections (HTTPS).</p>
        </section>

        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">4. Your choices</h2>
            <ul class="mt-3 list-disc space-y-2 pl-6 text-ink-dim">
            <li><strong class="text-ink">Ad consent:</strong> If you are in the EEA, UK or Switzerland, or another region where consent is required, Skydesk asks for your consent before showing personalized ads.</li>
            <li><strong class="text-ink">Advertising ID:</strong> You can reset or delete your advertising ID in Android Settings › Privacy › Ads.</li>
            <li><strong class="text-ink">Do Not Disturb:</strong> Skydesk only turns on Do Not Disturb if you switch it on for a flight and grant access; it puts your previous setting back when the flight lands or ends. You can revoke the access in Android Settings at any time.</li>
            <li><strong class="text-ink">Deleting data:</strong> Uninstalling Skydesk or clearing its storage removes everything the app keeps on your device. To request deletion of analytics data linked to your app instance, contact us at the address below.</li>
            </ul>
        </section>

        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">5. Data retention</h2>
            <p class="mt-3 text-ink-dim">Your flights stay on your device until you delete them, clear the app's storage or uninstall the app. Firebase Analytics data is retained for up to 14 months; Crashlytics crash data for up to 90 days. Advertising data is retained according to Google's policies.</p>
        </section>

        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">6. Children</h2>
            <p class="mt-3 text-ink-dim">Skydesk is not directed at children under 13 and we do not knowingly collect personal information from them. If you believe a child has provided information through the app, contact us and we will take steps to delete it.</p>
        </section>

        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">7. Your rights</h2>
            <p class="mt-3 text-ink-dim">Depending on where you live (for example under the GDPR, UK GDPR, KVKK or CCPA), you may have the right to access, correct, delete or object to the processing of your personal data, and to withdraw consent. Because we do not hold an account or your flight history, most data is held by the Google services listed above; contact us and we will help with any request.</p>
        </section>

        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">8. Changes to this policy</h2>
            <p class="mt-3 text-ink-dim">We may update this policy when the app changes. The new version will be posted on this page with a new effective date.</p>
        </section>

        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">9. Contact</h2>
            <p class="mt-3 text-ink-dim">Zettelabs — <a class="text-accent underline underline-offset-2 hover:text-accent-deep" href="mailto:zettelabs@gmail.com">zettelabs@gmail.com</a></p>
        </section>
    </div>

@endsection
