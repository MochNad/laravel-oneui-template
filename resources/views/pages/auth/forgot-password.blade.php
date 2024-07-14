<x-layouts.auth.app title="Forgot Password" description="Reset your password" author="Moch. Nad"
    ogTitle="Forgot Password Page" ogSiteName="{{ config('app.name') }}"
    ogDescription="Reset your password on {{ config('app.name') }}" ogUrl="" ogImage=""
    blockTitle="Forgot Password" hrefOptionIcon="{{ route('login') }}" titleOptionIcon="Sign In"
    optionIcon="fa-sign-in-alt" headerTitle="{{ config('app.name') }}"
    headerSubTitle="Enter your email to reset your password" formAction="{{ route('password.email') }}"
    buttonIcon="fa-envelope" buttonText="Send" copyrightText="{{ config('app.name') }}"
    :inputs="[
        [
            'type' => 'email',
            'id' => 'email_field',
            'name' => 'email',
            'placeholder' => 'Email',
            'validation' => 'required|email',
        ],
    ]" />
