<x-layouts.auth.app headerBlockTitle="Create Account" headerHrefOptionText="javascript:void(0)"
    headerOptionText="View Terms" headerHrefOptionIcon="{{ route('login') }}" headerOptionIcon="fa-sign-in-alt"
    headerTitleOptionIcon="Sign In" headerTitleModal="Terms and Conditions" headerAggreeText="I Agree"
    contentHeaderSubTitle="Please fill the following details to create a new account."
    contentFormAction="{{ route('register') }}" contentButtonSubmitIcon="fa-user-plus" contentButtonSubmitText="Sign Up" :contentInputs="[
        [
            'type' => 'text',
            'id' => 'name_field',
            'name' => 'name',
            'placeholder' => 'Name',
            'validation' => 'min:3',
            'attribute' => 'required',
        ],
        [
            'type' => 'email',
            'id' => 'email_field',
            'name' => 'email',
            'placeholder' => 'Email',
            'attribute' => 'required',
        ],
        [
            'type' => 'password',
            'id' => 'password_field',
            'name' => 'password',
            'placeholder' => 'Password',
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
        [
            'type' => 'checkbox',
            'id' => 'terms_field',
            'name' => 'terms',
            'placeholder' => 'I agree to the terms and conditions',
            'validation' => 'accepted',
        ],
    ]"
    :headerTerms="[
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
