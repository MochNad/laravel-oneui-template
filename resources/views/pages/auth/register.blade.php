<x-layouts.auth.app title="Register" description="Create a new account" author="Moch. Nad" ogTitle="Register Page"
    ogSiteName="{{ config('app.name') }}" ogDescription="Register to create a new account on {{ config('app.name') }}"
    ogUrl="" ogImage="" blockTitle="Create Account" hrefOptionText="javascript:void(0)"
    hrefOptionIcon="{{ route('login') }}" titleOptionIcon="Sign In" optionIcon="fa-sign-in-alt"
    headerTitle="{{ config('app.name') }}" headerSubTitle="Please fill the following details to create a new account."
    formAction="{{ route('register') }}" titleModal="Terms and Conditions" aggreeText="I Agree" optionText="View Terms"
    buttonIcon="fa-user-plus" buttonText="Sign Up" copyrightText="{{ config('app.name') }}" :inputs="[
        [
            'type' => 'text',
            'id' => 'name_field',
            'name' => 'name',
            'placeholder' => 'Name',
            'validation' => 'required|min:3',
        ],
        [
            'type' => 'email',
            'id' => 'email_field',
            'name' => 'email',
            'placeholder' => 'Email',
            'validation' => 'required|email',
        ],
        [
            'type' => 'password',
            'id' => 'password_field',
            'name' => 'password',
            'placeholder' => 'Password',
            'validation' => 'required|capitals|numbers|specials|min:8',
        ],
        [
            'type' => 'password',
            'id' => 'password_confirmation_field',
            'name' => 'password_confirmation',
            'placeholder' => 'Confirm Password',
            'validation' => 'required|same:password',
        ],
        [
            'type' => 'checkbox',
            'id' => 'terms_field',
            'name' => 'terms',
            'placeholder' => 'I agree to the terms and conditions',
            'validation' => 'accepted',
        ],
    ]"
    :terms="[
        [
            'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolores, nemo!',
        ],
        [
            'content' =>
                'Lorem ipsum dolor sit amet consectetur adipisicing elit. Suscipit, temporibus nulla! Itaque, corrupti assumenda amet ullam id unde neque quibusdam.',
        ],
        [
            'content' =>
                'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi modi, ex omnis facere cumque obcaecati neque recusandae eum fugiat quam eos nulla unde nostrum veritatis, consequatur explicabo? Delectus, corrupti repellendus!.',
        ],
        [
            'content' =>
                'Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem doloremque omnis voluptate tenetur in eius amet eaque illo animi iusto, consequatur veniam expedita sit culpa sunt officia, cum aspernatur? Ipsum saepe laboriosam libero molestias ratione fugiat cum. Eos, laborum ipsa!',
        ],
    ]" />
