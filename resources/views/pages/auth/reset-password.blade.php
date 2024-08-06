<x-layouts.auth.app headerBlockTitle="Reset Password" headerHrefOptionIcon="{{ route('login') }}"
    headerTitleOptionIcon="Login" headerOptionIcon="fa-sign-in-alt"
    contentHeaderSubTitle="Enter new password to reset your password" contentFormAction="{{ route('password.store') }}"
    contentButtonSubmitIcon="fa-check" contentButtonSubmitText="Reset" :contentInputs="[
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
            'attribute' => 'readonly required',
        ],
        [
            'type' => 'password',
            'id' => 'password_field',
            'name' => 'password',
            'placeholder' => 'New Password',
            'validation' => 'has_capitals|has_numbers|has_specials|min:8',
            'attribute' => 'required',
        ],
        [
            'type' => 'password',
            'id' => 'password_confirmation_field',
            'name' => 'password_confirmation',
            'placeholder' => 'Confirm Password',
            'validation' => 'same:password',
            'attribute' => 'required',
        ],
    ]" />
