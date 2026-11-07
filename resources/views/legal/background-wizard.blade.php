@extends('layouts.site')

@section('title', 'Background Wizard Privacy Policy')
@section('description', 'Privacy policy for Background Wizard, an Android app by Zettelabs.')

@section('content')

    <div class="mx-auto max-w-3xl px-6 py-16 md:py-20">
        <span class="inline-flex items-center gap-2 rounded-full border border-line bg-accent-soft px-3 py-1 font-mono text-xs uppercase tracking-wider text-accent-deep">
            Privacy Policy
        </span>
        <h1 class="mt-5 text-3xl font-semibold text-ink md:text-4xl">Background Wizard Privacy Policy</h1>
        <p class="mt-4 text-sm text-ink-dim">App: Background Wizard (background.erase.replace.change.blur.remove) · Developer: Zettelabs · Effective: 7 November 2026 · Applies to version 2.0 and later</p>

        <p class="mt-8 text-ink-dim">This policy explains what information Background Wizard handles, why, and the choices you have. Background Wizard does not require an account and does not ask for your name, email address, phone number or contacts.</p>

        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">1. Your photos stay on your device</h2>
            <p class="mt-3 text-ink-dim">You choose each photo yourself, through the Android photo picker or by taking a new picture with your camera app. Background Wizard only receives the photos you pick; it cannot browse the rest of your gallery.</p>
            <p class="mt-3 text-ink-dim">Finding the subject, removing or replacing the background and blurring all happen on your device, using Google's on-device ML Kit. Your photos and edits are never uploaded to us or to any third party. An edited photo is written to your gallery (in a "Background Wizard" album) only when you tap Save. When you share a photo, a temporary copy is kept in the app's private cache so the app you share to can read it.</p>
        </section>

        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">2. Permissions</h2>
            <div class="mt-3 overflow-x-auto">
                <table class="w-full border-collapse text-left text-sm text-ink-dim">
                    <thead>
                        <tr class="border-b border-line text-ink"><th class="p-2 font-semibold">Permission</th><th class="p-2 font-semibold">Why</th></tr>
                    </thead>
                    <tbody class="[&_td]:border-b [&_td]:border-line [&_td]:p-2 [&_td]:align-top">
                        <tr><td>Internet</td><td>To download background images, and to load ads, app configuration, analytics and crash reports (see below). Photos are never sent.</td></tr>
                        <tr><td>Storage (WRITE_EXTERNAL_STORAGE, READ_EXTERNAL_STORAGE; Android 9 and older only)</td><td>To save your edited photo to the gallery on older Android versions (write access, and read access that older Android versions require alongside it). Newer versions need no permission for this.</td></tr>
                    </tbody>
                </table>
            </div>
            <p class="mt-3 text-ink-dim">Background Wizard does not request camera, microphone, contacts, location or photo-library permissions. Taking a picture opens your own camera app.</p>
        </section>

        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">3. Background images</h2>
            <p class="mt-3 text-ink-dim">The Replace tool's background images are downloaded from the jsDelivr content delivery network (cdn.jsdelivr.net). Like any website, the CDN receives your IP address and basic request information when an image is downloaded. Nothing about your photos is sent with these requests.</p>
        </section>

        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">4. Information collected by third-party services</h2>
            <p class="mt-3 text-ink-dim">Background Wizard is free and supported by ads. It uses the following Google services, which may collect information automatically from your device:</p>
            <div class="mt-3 overflow-x-auto">
                <table class="w-full border-collapse text-left text-sm text-ink-dim">
                    <thead>
                        <tr class="border-b border-line text-ink"><th class="p-2 font-semibold">Service</th><th class="p-2 font-semibold">Purpose</th><th class="p-2 font-semibold">Data it may collect</th></tr>
                    </thead>
                    <tbody class="[&_td]:border-b [&_td]:border-line [&_td]:p-2 [&_td]:align-top">
                        <tr><td>Google AdMob</td><td>Showing ads (app open, interstitial, native and rewarded ads)</td><td>Advertising ID, IP address, device and app information, ad interactions</td></tr>
                        <tr><td>Google User Messaging Platform</td><td>Asking for and storing your ad consent where required by law</td><td>Your consent choices, device information</td></tr>
                        <tr><td>Google ML Kit (subject segmentation)</td><td>Finding the subject in your photo, on your device</td><td>The model runs on your device; Google Play services may download the model and collect usage and diagnostic information about the API. Your photos are not sent.</td></tr>
                        <tr><td>Firebase Analytics</td><td>Understanding how the app is used (for example, which tools are opened) so we can improve it</td><td>App usage events, app instance ID, device and app information, approximate location derived from IP</td></tr>
                        <tr><td>Firebase Crashlytics</td><td>Diagnosing crashes</td><td>Crash logs, device state at the time of the crash, app instance ID</td></tr>
                        <tr><td>Firebase Remote Config</td><td>Adjusting app settings, such as ad frequency, without an update</td><td>App instance ID, device and app information</td></tr>
                    </tbody>
                </table>
            </div>
            <p class="mt-3 text-ink-dim">These services are governed by their own policies: <a class="text-accent underline underline-offset-2 hover:text-accent-deep" href="https://policies.google.com/privacy">Google Privacy Policy</a>, <a class="text-accent underline underline-offset-2 hover:text-accent-deep" href="https://policies.google.com/technologies/partner-sites">How Google uses information from apps that use its services</a>, <a class="text-accent underline underline-offset-2 hover:text-accent-deep" href="https://developers.google.com/ml-kit/terms">ML Kit terms</a> and <a class="text-accent underline underline-offset-2 hover:text-accent-deep" href="https://firebase.google.com/support/privacy">Firebase privacy information</a>.</p>
            <p class="mt-3 text-ink-dim">We do not sell your personal information. Data is transmitted over encrypted connections (HTTPS).</p>
        </section>

        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">5. Your choices</h2>
            <p class="mt-3 text-ink-dim"><strong class="text-ink">Ad consent:</strong> If you are in the EEA, UK or Switzerland, or another region where consent is required, Background Wizard asks for your consent before showing personalized ads. You can change your choice at any time from Privacy settings on the Home screen.</p>
            <p class="mt-3 text-ink-dim"><strong class="text-ink">Advertising ID:</strong> You can reset or delete your advertising ID in Android Settings › Privacy › Ads.</p>
            <p class="mt-3 text-ink-dim"><strong class="text-ink">Deleting data:</strong> Uninstalling Background Wizard or clearing its storage removes all data the app keeps on your device. Photos you saved stay in your gallery until you delete them. To request deletion of analytics data linked to your app instance, contact us at the address below.</p>
        </section>

        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">6. Data retention</h2>
            <p class="mt-3 text-ink-dim">The app keeps only small settings (such as whether you have seen the introduction) and temporary share copies on your device. Firebase Analytics data is retained for up to 14 months; Crashlytics crash data for up to 90 days. Advertising data is retained according to Google's policies.</p>
        </section>

        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">7. Children</h2>
            <p class="mt-3 text-ink-dim">Background Wizard is not directed at children under 13 and we do not knowingly collect personal information from them. If you believe a child has provided information through the app, contact us and we will take steps to delete it.</p>
        </section>

        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">8. Your rights</h2>
            <p class="mt-3 text-ink-dim">Depending on where you live (for example under the GDPR, UK GDPR, KVKK or CCPA), you may have the right to access, correct, delete or object to the processing of your personal data, and to withdraw consent. Because we do not hold an account or your photos, most data is held by the Google services listed above; contact us and we will help with any request.</p>
        </section>

        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">9. Changes to this policy</h2>
            <p class="mt-3 text-ink-dim">We may update this policy when the app changes. The new version will be posted on this page with a new effective date.</p>
        </section>

        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">10. Contact</h2>
            <p class="mt-3 text-ink-dim">Zettelabs — <a class="text-accent underline underline-offset-2 hover:text-accent-deep" href="mailto:zettelabs@gmail.com">zettelabs@gmail.com</a></p>
        </section>
    </div>

@endsection
