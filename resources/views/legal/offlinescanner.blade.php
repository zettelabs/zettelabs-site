@extends('layouts.site')

{{-- Same text as ~/offlinescanner/docs/privacy-policy.html; keep the two in step. --}}
@section('title', 'Offline Scanner Privacy Policy')
@section('description', 'Privacy policy for Offline Scanner: PDF & OCR, an Android app by Zettelabs.')

@section('content')

    <div class="mx-auto max-w-3xl px-6 py-16 md:py-20">
        <span class="inline-flex items-center gap-2 rounded-full border border-line bg-accent-soft px-3 py-1 font-mono text-xs uppercase tracking-wider text-accent-deep">
            Privacy Policy
        </span>
        <h1 class="mt-5 text-3xl font-semibold text-ink md:text-4xl">Offline Scanner Privacy Policy</h1>
        <p class="mt-4 text-sm text-ink-dim">App: Offline Scanner: PDF &amp; OCR (com.scanner.offline.pdf.ocr) · Developer: Zettelabs · Effective: 9 November 2026 · Applies to version 0.1.0 and later</p>

        <p class="mt-8 text-ink-dim">This policy explains what information Offline Scanner handles, why, and the choices you have. Offline Scanner does not require an account and does not ask for your name, email address, phone number or contacts.</p>

        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">1. Your documents stay on your device</h2>
            <p class="mt-3 text-ink-dim">Offline Scanner captures documents with your camera or imports them from your gallery, straightens them, saves them as a PDF and recognizes the text on each page. All of this happens on your device, using Google ML Kit libraries that run locally. Your scans, the PDFs and the recognized text are stored only in the app's private storage on your phone and are <strong class="text-ink">never uploaded</strong> to us or to any third party.</p>
            <p class="mt-3 text-ink-dim">When you choose <em>Share</em>, the PDF or text is handed to the app you pick (for example your email or messaging app). From that point the receiving app's policy applies.</p>
            <p class="mt-3 text-ink-dim">The document-capture interface is provided by Google Play services. The first time you scan, Play services downloads that module once (about 200 KB). Afterwards scanning works without an internet connection.</p>
        </section>

        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">2. Permissions</h2>
            <div class="mt-3 overflow-x-auto"><table class="w-full border-collapse text-left text-sm text-ink-dim">
            <thead><tr class="border-b border-line text-ink"><th class="p-2 font-semibold">Permission</th><th class="p-2 font-semibold">Why</th></tr></thead><tbody class="[&_td]:border-b [&_td]:border-line [&_td]:p-2 [&_td]:align-top">
            <tr><td>Camera (requested by the Google Play services scanner screen)</td><td>To photograph the document you want to scan. Offline Scanner itself declares no camera permission; the Play services module asks when you first scan.</td></tr>
            <tr><td>Photos (system photo picker)</td><td>Only the photos you pick are handed to the app. No broad gallery access is requested.</td></tr>
            <tr><td>Internet</td><td>To load ads, app configuration and crash reports (see below). Documents are never sent.</td></tr>
            </tbody></table></div>
        </section>

        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">3. Information collected by third-party services</h2>
            <p class="mt-3 text-ink-dim">Offline Scanner is free and supported by ads. It uses the following Google services, which may collect information automatically from your device:</p>
            <div class="mt-3 overflow-x-auto"><table class="w-full border-collapse text-left text-sm text-ink-dim">
            <thead><tr class="border-b border-line text-ink"><th class="p-2 font-semibold">Service</th><th class="p-2 font-semibold">Purpose</th><th class="p-2 font-semibold">Data it may collect</th></tr></thead><tbody class="[&_td]:border-b [&_td]:border-line [&_td]:p-2 [&_td]:align-top">
            <tr><td>Google AdMob</td><td>Showing ads (app open and interstitial ads)</td><td>Advertising ID, IP address, device and app information, ad interactions</td></tr>
            <tr><td>Google User Messaging Platform</td><td>Asking for and storing your ad consent where required by law</td><td>Your consent choices, device information</td></tr>
            <tr><td>Firebase Analytics</td><td>Understanding how the app is used (for example whether a scan is completed) so we can improve it</td><td>App usage events, app instance ID, device and app information, approximate location derived from IP</td></tr>
            <tr><td>Firebase Crashlytics</td><td>Diagnosing crashes</td><td>Crash logs, device state at the time of the crash, app instance ID</td></tr>
            <tr><td>Firebase Remote Config</td><td>Adjusting app settings, such as ad frequency, without an update</td><td>App instance ID, device and app information</td></tr>
            </tbody></table></div>
            <p class="mt-3 text-ink-dim">These services are governed by their own policies: <a class="text-accent underline underline-offset-2 hover:text-accent-deep" href="https://policies.google.com/privacy">Google Privacy Policy</a>, <a class="text-accent underline underline-offset-2 hover:text-accent-deep" href="https://policies.google.com/technologies/partner-sites">How Google uses information from apps that use its services</a>, and <a class="text-accent underline underline-offset-2 hover:text-accent-deep" href="https://firebase.google.com/support/privacy">Firebase privacy information</a>.</p>
            <p class="mt-3 text-ink-dim">We do not sell your personal information. Data is transmitted over encrypted connections (HTTPS).</p>
        </section>

        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">4. Your choices</h2>
            <ul class="mt-3 list-disc space-y-2 pl-6 text-ink-dim">
            <li><strong class="text-ink">Ad consent:</strong> If you are in the EEA, UK or Switzerland, or another region where consent is required, Offline Scanner asks for your consent before showing personalized ads.</li>
            <li><strong class="text-ink">Advertising ID:</strong> You can reset or delete your advertising ID in Android Settings › Privacy › Ads.</li>
            <li><strong class="text-ink">Deleting data:</strong> Deleting a scan in the app removes its PDF, images and text from your phone. Uninstalling Offline Scanner or clearing its storage removes everything the app keeps on your device. To request deletion of analytics data linked to your app instance, contact us at the address below.</li>
            </ul>
        </section>

        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">5. Data retention</h2>
            <p class="mt-3 text-ink-dim">Scans stay on your device until you delete them, clear the app's storage or uninstall the app. Firebase Analytics data is retained for up to 14 months; Crashlytics crash data for up to 90 days. Advertising data is retained according to Google's policies.</p>
        </section>

        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">6. Children</h2>
            <p class="mt-3 text-ink-dim">Offline Scanner is not directed at children under 13 and we do not knowingly collect personal information from them. If you believe a child has provided information through the app, contact us and we will take steps to delete it.</p>
        </section>

        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">7. Your rights</h2>
            <p class="mt-3 text-ink-dim">Depending on where you live (for example under the GDPR, UK GDPR, KVKK or CCPA), you may have the right to access, correct, delete or object to the processing of your personal data, and to withdraw consent. Because we do not hold an account or your documents, most data is held by the Google services listed above; contact us and we will help with any request.</p>
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
