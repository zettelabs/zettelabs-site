@extends('layouts.site')

@section('title', 'CirclePix Privacy Policy')
@section('description', 'Privacy policy for CirclePix, an Android app by Zettelabs.')

@section('content')

    <div class="mx-auto max-w-3xl px-6 py-16 md:py-20">
        <span class="inline-flex items-center gap-2 rounded-full border border-line bg-accent-soft px-3 py-1 font-mono text-xs uppercase tracking-wider text-accent-deep">
            Privacy Policy
        </span>
        <h1 class="mt-5 text-3xl font-semibold text-ink md:text-4xl">CirclePix Privacy Policy</h1>
        <p class="mt-4 text-sm text-ink-dim">App: CirclePix – Profile Picture Maker (com.remove.background.change.photo) · Developer: Zettelabs · Effective: 22 October 2026</p>

        <p class="mt-8 text-ink-dim">This policy explains what information CirclePix handles, why, and the choices you have. CirclePix does not require an account and does not ask for your name, email address, phone number or contacts.</p>

        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">1. Your photos stay on your device</h2>
            <p class="mt-3 text-ink-dim">CirclePix turns a photo you pick or take into a profile picture: it cuts out the subject and places it in a styled circle. Background removal uses Google ML Kit subject segmentation, which runs <strong class="text-ink">entirely on your device</strong>. The segmentation model is downloaded once through Google Play services; your photos are not sent with that download. CirclePix <strong class="text-ink">never uploads</strong> your photos or the pictures you create to us or to any third party.</p>
            <p class="mt-3 text-ink-dim">When you tap <em>Save</em>, the picture is written to your gallery in <em>Pictures/Profile Picture Maker</em>. Photos you take with the in-app camera are saved to <em>Pictures/CameraX-Image</em>. When you tap <em>Share</em>, the picture is handed to the Android share sheet and goes only to the app you choose.</p>
        </section>

        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">2. Permissions</h2>
            <div class="mt-3 overflow-x-auto"><table class="w-full border-collapse text-left text-sm text-ink-dim">
            <thead><tr class="border-b border-line text-ink"><th class="p-2 font-semibold">Permission</th><th class="p-2 font-semibold">Why</th></tr></thead><tbody class="[&_td]:border-b [&_td]:border-line [&_td]:p-2 [&_td]:align-top">
            <tr><td>Camera</td><td>To take a photo with the in-app camera. Only requested when you choose to use the camera.</td></tr>
            <tr><td>Storage (WRITE_EXTERNAL_STORAGE on Android 9 and earlier; READ_EXTERNAL_STORAGE)</td><td>To save your pictures to the gallery on older Android versions. On newer versions, CirclePix uses the system photo picker, which gives the app access only to the photo you select, and saves without any storage permission.</td></tr>
            <tr><td>Internet</td><td>To download the background-removal model and to load ads, app configuration, analytics and crash reports (see below). Photos are never sent.</td></tr>
            </tbody></table></div>
        </section>

        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">3. Information collected by third-party services</h2>
            <p class="mt-3 text-ink-dim">CirclePix is free and supported by ads. It uses the following Google services, which may collect information automatically from your device:</p>
            <div class="mt-3 overflow-x-auto"><table class="w-full border-collapse text-left text-sm text-ink-dim">
            <thead><tr class="border-b border-line text-ink"><th class="p-2 font-semibold">Service</th><th class="p-2 font-semibold">Purpose</th><th class="p-2 font-semibold">Data it may collect</th></tr></thead><tbody class="[&_td]:border-b [&_td]:border-line [&_td]:p-2 [&_td]:align-top">
            <tr><td>Google AdMob</td><td>Showing ads (native, interstitial, app open and rewarded ads; a rewarded ad unlocks Pro styles for a limited time)</td><td>Advertising ID, IP address, device and app information, ad interactions</td></tr>
            <tr><td>Google User Messaging Platform</td><td>Asking for and storing your ad consent where required by law</td><td>Your consent choices, device information</td></tr>
            <tr><td>Firebase Analytics</td><td>Understanding how the app is used (for example, which screens are opened) so we can improve it</td><td>App usage events, app instance ID, device and app information, approximate location derived from IP</td></tr>
            <tr><td>Firebase Crashlytics</td><td>Diagnosing crashes</td><td>Crash logs, device state at the time of the crash, app instance ID</td></tr>
            <tr><td>Firebase Remote Config</td><td>Adjusting app settings, such as ad frequency and how long Pro styles stay unlocked, without an update</td><td>App instance ID, device and app information</td></tr>
            <tr><td>Google Play services (ML Kit)</td><td>Downloading the on-device background-removal model</td><td>Device and app information needed to deliver the model; not your photos</td></tr>
            </tbody></table></div>
            <p class="mt-3 text-ink-dim">These services are governed by their own policies: <a class="text-accent underline underline-offset-2 hover:text-accent-deep" href="https://policies.google.com/privacy">Google Privacy Policy</a>, <a class="text-accent underline underline-offset-2 hover:text-accent-deep" href="https://policies.google.com/technologies/partner-sites">How Google uses information from apps that use its services</a>, and <a class="text-accent underline underline-offset-2 hover:text-accent-deep" href="https://firebase.google.com/support/privacy">Firebase privacy information</a>.</p>
            <p class="mt-3 text-ink-dim">We do not sell your personal information. Data is transmitted over encrypted connections (HTTPS).</p>
        </section>

        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">4. Your choices</h2>
            <ul class="mt-3 list-disc space-y-2 pl-6 text-ink-dim">
            <li><strong class="text-ink">Ad consent:</strong> If you are in the EEA, UK or Switzerland, or another region where consent is required, CirclePix asks for your consent before showing personalized ads. You can change your choice at any time from <em>Privacy settings</em> on the Home screen.</li>
            <li><strong class="text-ink">Advertising ID:</strong> You can reset or delete your advertising ID in Android Settings › Privacy › Ads.</li>
            <li><strong class="text-ink">Permissions:</strong> You can revoke camera or storage access in Android Settings › Apps › CirclePix › Permissions.</li>
            <li><strong class="text-ink">Deleting data:</strong> Pictures you saved stay in your gallery until you delete them there. Uninstalling CirclePix or clearing its storage removes everything else the app keeps on your device. To request deletion of analytics data linked to your app instance, contact us at the address below.</li>
            </ul>
        </section>

        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">5. Data retention</h2>
            <p class="mt-3 text-ink-dim">CirclePix keeps no copies of your photos outside your gallery, apart from temporary working files in its private storage, which are removed when you clear the app's storage or uninstall it. Firebase Analytics data is retained for up to 14 months; Crashlytics crash data for up to 90 days. Advertising data is retained according to Google's policies.</p>
        </section>

        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">6. Children</h2>
            <p class="mt-3 text-ink-dim">CirclePix is not directed at children under 13 and we do not knowingly collect personal information from them. If you believe a child has provided information through the app, contact us and we will take steps to delete it.</p>
        </section>

        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">7. Your rights</h2>
            <p class="mt-3 text-ink-dim">Depending on where you live (for example under the GDPR, UK GDPR, KVKK or CCPA), you may have the right to access, correct, delete or object to the processing of your personal data, and to withdraw consent. Because we do not hold an account or your photos, most data is held by the Google services listed above; contact us and we will help with any request.</p>
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
