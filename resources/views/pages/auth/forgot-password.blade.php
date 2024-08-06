<x-layouts.auth.app headerBlockTitle="Forgot Password" headerHrefOptionIcon="{{ route('login') }}"
    headerTitleOptionIcon="Sign In" headerOptionIcon="fa-sign-in-alt"
    contentHeaderSubTitle="Enter your email to reset your password" contentFormAction="{{ route('password.email') }}"
    contentButtonSubmitIcon="fa-envelope" contentButtonSubmitText="Send" copyrightText="{{ config('app.name') }}" :contentInputs="[
        [
            'type' => 'email',
            'id' => 'email_field',
            'name' => 'email',
            'placeholder' => 'Email',
            'attribute' => 'required',
        ],
    ]" />
