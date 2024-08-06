<x-layouts.auth.app headerBlockTitle="Verify Email" headerHrefOptionIcon="{{ route('logout') }}"
    headerTitleOptionIcon="Log Out" headerOptionIcon="fa-sign-out-alt"
    contentHeaderSubTitle="We have sent to {{ auth()->user()->email }} a verification email. Please check your inbox or spam folder."
    contentFormAction="{{ route('verification.send') }}" contentButtonSubmitIcon="fa-envelope"
    contentButtonSubmitText="Resend" :headerHrefOptionForm="true" />
