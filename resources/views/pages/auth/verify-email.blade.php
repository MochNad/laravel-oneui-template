<x-layouts.auth.app title="Verify Email" description="Verify your email address" author="Moch. Nad" ogTitle="Verify Email"
    ogSiteName="{{ config('app.name') }}" ogDescription="Verify your email address on {{ config('app.name') }}"
    ogUrl="" ogImage="" blockTitle="Verify Email" hrefOptionIcon="{{ route('logout') }}" titleOptionIcon="Log Out"
    optionIcon="fa-sign-out-alt" headerTitle="{{ config('app.name') }}"
    headerSubTitle="Please verify {{ Auth::user()->email }} to complete registration."
    formAction="{{ route('verification.send') }}" buttonIcon="fa-envelope" buttonText="Resend"
    copyrightText="{{ config('app.name') }}" :hrefOptionForm="true" />
