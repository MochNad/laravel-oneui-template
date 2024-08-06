<x-layouts.auth.app headerBlockTitle="Sign In" headerHrefOptionText="{{ route('password.request') }}"
    headerOptionText="Forgot Password?" headerHrefOptionIcon="{{ route('register') }}" headerOptionIcon="fa-user-plus"
    headerTitleOptionIcon="New Account" contentHeaderSubTitle="Welcome, please login"
    contentFormAction="{{ route('login') }}" contentButtonSubmitIcon="fa-sign-in-alt" contentButtonSubmitText="Sign In"
    :contentInputs="[
        [
            'type' => 'email',
            'id' => 'email_field',
            'name' => 'email',
            'type' => 'email',
            'placeholder' => 'Email',
            'attribute' => 'required',
        ],
        [
            'type' => 'password',
            'id' => 'password_field',
            'name' => 'password',
            'type' => 'password',
            'placeholder' => 'Password',
            'attribute' => 'required',
        ],
        [
            'type' => 'checkbox',
            'id' => 'remember_field',
            'name' => 'remember',
            'placeholder' => 'Remember me',
        ],
    ]" />
