@extends('layouts.site')

@section('title', 'Simple Alarm Privacy Policy')
@section('description', 'Privacy policy for Simple Alarm, an Android app by Zettelabs.')

@section('content')

    <div class="mx-auto max-w-3xl px-6 py-16 md:py-20">
        <span class="inline-flex items-center gap-2 rounded-full border border-line bg-accent-soft px-3 py-1 font-mono text-xs uppercase tracking-wider text-accent-deep">
            Privacy Policy
        </span>
        <h1 class="mt-5 text-3xl font-semibold text-ink md:text-4xl">Simple Alarm Privacy Policy</h1>
        <p class="mt-4 text-sm text-ink-dim">App: Simple Alarm (com.alarm.simple.clock) · Developer: Zettelabs · Effective: 23 October 2026</p>

        <p class="mt-8 text-ink-dim">This policy explains what information Simple Alarm handles, why, and the choices you have. Simple Alarm does not require an account and does not ask for your name, email address, phone number or contacts.</p>

        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">1. Your alarms stay on your device</h2>
            <p class="mt-3 text-ink-dim">The alarms you create (time, repeat days, label, sound and background choice) are stored <strong class="text-ink">only on your device</strong>, in the app's private storage. They are never uploaded to us or to any third party.</p>
            <p class="mt-3 text-ink-dim">If you choose your own alarm sound, you pick the file through the Android file picker. Simple Alarm only gets access to the file you pick, keeps a reference to it so the alarm can play it, and never uploads it.</p>
            <p class="mt-3 text-ink-dim">Alarm screen background images are downloaded from our public content server (cdn.jsdelivr.net). Like any web request, this reveals your IP address to the content server; no other information is sent.</p>
        </section>

        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">2. Permissions</h2>
            <div class="mt-3 overflow-x-auto"><table class="w-full border-collapse text-left text-sm text-ink-dim">
            <thead><tr class="border-b border-line text-ink"><th class="p-2 font-semibold">Permission</th><th class="p-2 font-semibold">Why</th></tr></thead><tbody class="[&_td]:border-b [&_td]:border-line [&_td]:p-2 [&_td]:align-top">
            <tr><td>Alarms &amp; reminders (SCHEDULE_EXACT_ALARM, SET_ALARM)</td><td>To ring your alarm at exactly the time you set.</td></tr>
            <tr><td>Notifications (POST_NOTIFICATIONS) and full-screen intent</td><td>To show the ringing alarm over the lock screen and as a notification.</td></tr>
            <tr><td>Foreground service</td><td>To keep the alarm sound playing reliably while it rings.</td></tr>
            <tr><td>Vibrate, audio settings</td><td>To vibrate and to play the alarm at the right volume.</td></tr>
            <tr><td>Music and audio (READ_MEDIA_AUDIO)</td><td>To play an alarm sound you chose from your device.</td></tr>
            <tr><td>Internet</td><td>To download background images and to load ads, app configuration, analytics and crash reports (see below).</td></tr>
            </tbody></table></div>
        </section>

        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">3. Information collected by third-party services</h2>
            <p class="mt-3 text-ink-dim">Simple Alarm is free and supported by ads. It uses the following Google services, which may collect information automatically from your device:</p>
            <div class="mt-3 overflow-x-auto"><table class="w-full border-collapse text-left text-sm text-ink-dim">
            <thead><tr class="border-b border-line text-ink"><th class="p-2 font-semibold">Service</th><th class="p-2 font-semibold">Purpose</th><th class="p-2 font-semibold">Data it may collect</th></tr></thead><tbody class="[&_td]:border-b [&_td]:border-line [&_td]:p-2 [&_td]:align-top">
            <tr><td>Google AdMob</td><td>Showing ads (banner, interstitial and app open ads)</td><td>Advertising ID, IP address, device and app information, ad interactions</td></tr>
            <tr><td>Google User Messaging Platform</td><td>Asking for and storing your ad consent where required by law</td><td>Your consent choices, device information</td></tr>
            <tr><td>Firebase Analytics</td><td>Understanding how the app is used (for example, which screens are opened) so we can improve it</td><td>App usage events, app instance ID, device and app information, approximate location derived from IP</td></tr>
            <tr><td>Firebase Crashlytics</td><td>Diagnosing crashes</td><td>Crash logs, device state at the time of the crash, app instance ID</td></tr>
            <tr><td>Firebase Remote Config</td><td>Adjusting app settings, such as ad frequency, without an update</td><td>App instance ID, device and app information</td></tr>
            </tbody></table></div>
            <p class="mt-3 text-ink-dim">These services are governed by their own policies: <a class="text-accent underline underline-offset-2 hover:text-accent-deep" href="https://policies.google.com/privacy">Google Privacy Policy</a>, <a class="text-accent underline underline-offset-2 hover:text-accent-deep" href="https://policies.google.com/technologies/partner-sites">How Google uses information from apps that use its services</a>, and <a class="text-accent underline underline-offset-2 hover:text-accent-deep" href="https://firebase.google.com/support/privacy">Firebase privacy information</a>.</p>
            <p class="mt-3 text-ink-dim">We do not sell your personal information. Data is transmitted over encrypted connections (HTTPS).</p>
        </section>

        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">4. Your choices</h2>
            <ul class="mt-3 list-disc space-y-2 pl-6 text-ink-dim">
            <li><strong class="text-ink">Ad consent:</strong> If you are in the EEA, UK or Switzerland, or another region where consent is required, Simple Alarm asks for your consent before showing personalized ads. You can change your choice at any time from <em>Privacy settings</em> on the Home screen.</li>
            <li><strong class="text-ink">Advertising ID:</strong> You can reset or delete your advertising ID in Android Settings › Privacy › Ads.</li>
            <li><strong class="text-ink">Permissions:</strong> You can revoke notification, alarm or audio access in Android Settings › Apps › Simple Alarm. Alarms may not ring reliably without them.</li>
            <li><strong class="text-ink">Deleting data:</strong> Deleting an alarm in the app removes it. Uninstalling Simple Alarm or clearing its storage removes everything the app keeps on your device. To request deletion of analytics data linked to your app instance, contact us at the address below.</li>
            </ul>
        </section>

        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">5. Data retention</h2>
            <p class="mt-3 text-ink-dim">Your alarms are kept on your device until you delete them, clear the app's storage or uninstall the app. Firebase Analytics data is retained for up to 14 months; Crashlytics crash data for up to 90 days. Advertising data is retained according to Google's policies.</p>
        </section>

        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">6. Children</h2>
            <p class="mt-3 text-ink-dim">Simple Alarm is not directed at children under 13 and we do not knowingly collect personal information from them. If you believe a child has provided information through the app, contact us and we will take steps to delete it.</p>
        </section>

        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">7. Your rights</h2>
            <p class="mt-3 text-ink-dim">Depending on where you live (for example under the GDPR, UK GDPR, KVKK or CCPA), you may have the right to access, correct, delete or object to the processing of your personal data, and to withdraw consent. Because we do not hold an account or your alarms, most data is held by the Google services listed above; contact us and we will help with any request.</p>
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
