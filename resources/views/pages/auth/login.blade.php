<x-layouts.auth.app title="Login" description="Login to your account" author="Moch. Nad" ogTitle="Login Page"
    ogSiteName="{{ config('app.name') }}" ogDescription="Login to access your account on {{ config('app.name') }}"
    ogUrl="" ogImage="" blockTitle="Sign In" hrefOptionText="{{ route('password.request') }}"
    optionText="Forgot Password?" hrefOptionIcon="{{ route('register') }}" titleOptionIcon="New Account"
    optionIcon="fa-user-plus" headerTitle="{{ config('app.name') }}" headerSubTitle="Welcome, please login"
    formAction="{{ route('login') }}" buttonIcon="fa-sign-in-alt" buttonText="Sign In"
    copyrightText="{{ config('app.name') }}" :inputs="[
        [
            'type' => 'email',
            'id' => 'email_field',
            'name' => 'email',
            'type' => 'email',
            'placeholder' => 'Email',
            'validation' => 'required|email',
        ],
        [
            'type' => 'password',
            'id' => 'password_field',
            'name' => 'password',
            'type' => 'password',
            'placeholder' => 'Password',
            'validation' => 'required',
        ],
        [
            'type' => 'checkbox',
            'id' => 'remember_field',
            'name' => 'remember',
            'placeholder' => 'Remember me',
            'validation' => '',
        ],
    ]" />
