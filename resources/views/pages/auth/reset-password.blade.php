<x-layouts.auth.app title="Reset Password" description="Reset your password" author="Moch. Nad"
    ogTitle="Reset Password Page" ogSiteName="{{ config('app.name') }}"
    ogDescription="Reset your password on {{ config('app.name') }}" ogUrl="" ogImage=""
    blockTitle="Reset Password" hrefOptionIcon="{{ route('login') }}" titleOptionIcon="Login" optionIcon="fa-sign-in-alt"
    headerTitle="{{ config('app.name') }}" headerSubTitle="Enter new password to reset your password"
    formAction="{{ route('password.store') }}" buttonIcon="fa-check" buttonText="Reset"
    copyrightText="{{ config('app.name') }}" :inputs="[
        [
            'type' => 'hidden',
            'id' => 'token_field',
            'name' => 'token',
            'value' => $request->route('token'),
        ],
        [
            'type' => 'email',
            'id' => 'email_field',
            'name' => 'email',
            'placeholder' => 'Email',
            'value' => $request->email,
            'attribute' => 'readonly',
            'validation' => 'required|email',
        ],
        [
            'type' => 'password',
            'id' => 'password_field',
            'name' => 'password',
            'placeholder' => 'New Password',
            'validation' => 'required|capitals|numbers|specials|min:8',
        ],
        [
            'type' => 'password',
            'id' => 'password_confirmation_field',
            'name' => 'password_confirmation',
            'placeholder' => 'Confirm Password',
            'validation' => 'required|same:password',
        ],
    ]" />
