@can($globalModule['read'])
    <x-layouts.dashboard.app>
        <x-slot name="content">
            @can($globalModule['read'])
                <div class="bg-image"
                    style="background-image: url({{ getFileStorageUrl($user->profile?->banner, 'assets/media/photos/photo12@2x.jpg') }});"
                    bis_skin_checked="1">
                    <div class="bg-black-50" bis_skin_checked="1">
                        <div class="content content-full text-center" bis_skin_checked="1">
                            <div class="my-3" bis_skin_checked="1">
                                <img class="img-avatar img-avatar-thumb"
                                    src="{{ getFileStorageUrl($user->profile?->picture, 'assets/media/avatars/avatar10.jpg') }}"
                                    alt="{{ $user->name }}" bis_skin_checked="1">
                            </div>
                            <h1 class="h2 text-white mb-0">{{ $user->name }}</h1>
                            <span class="text-white-75">{{ $user->role }}</span>
                        </div>
                    </div>
                </div>
                <div class="bg-body-extra-light" bis_skin_checked="1">
                    <div class="content content-boxed" bis_skin_checked="1">
                        <div class="row items-push text-center" bis_skin_checked="1">
                            <div class="col-6 col-md-6" bis_skin_checked="1">
                                <div class="fs-sm fw-semibold text-muted text-uppercase" bis_skin_checked="1">Date Joined</div>
                                <a class="link-fx fs-3"
                                    href="javascript:void(0)">{{ $user->created_at->format('l, d F Y') }}</a>
                            </div>
                            <div class="col-6 col-md-6" bis_skin_checked="1">
                                <div class="fs-sm fw-semibold text-muted text-uppercase" bis_skin_checked="1">Account Age</div>
                                <a class="link-fx fs-3" href="javascript:void(0)">{{ $user->created_at->diffForHumans() }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
            @can($globalModule['update'])
                <div class="content content-boxed" bis_skin_checked="1">
                    <div class="row" bis_skin_checked="1">
                        <div class="col-md-8" bis_skin_checked="1">
                            <x-interface.input :action="route('profile.update.account')" :put="true" title="Account" :inputs="[
                                [
                                    'type' => 'text',
                                    'id' => 'name',
                                    'name' => 'name',
                                    'label' => 'Name',
                                    'placeholder' => 'Enter your name',
                                    'value' => auth()->user()->name,
                                    'validation' => 'min:3|max:20',
                                    'attribute' => 'required',
                                ],
                                [
                                    'type' => 'email',
                                    'id' => 'email',
                                    'name' => 'email',
                                    'label' => 'Email',
                                    'placeholder' => 'Enter your email',
                                    'value' => auth()->user()->email,
                                    'validation' => 'email',
                                    'attribute' => 'required',
                                ],
                                [
                                    'type' => 'password',
                                    'id' => 'password',
                                    'name' => 'password',
                                    'label' => 'Password',
                                    'placeholder' => 'Enter your password',
                                    'validation' => 'optional|has_capitals|has_numbers|has_specials|min:8',
                                ],
                                [
                                    'type' => 'password',
                                    'id' => 'password_confirmation',
                                    'name' => 'password_confirmation',
                                    'label' => 'Confirm Password',
                                    'placeholder' => 'Confirm your password',
                                    'validation' => 'optional|same:password',
                                ],
                            ]" />
                        </div>
                        <div class="col-md-4" bis_skin_checked="1">
                            <x-interface.dropzone :action="route('profile.update.picture')" :put="true" id="picture" title="Picture"
                                message="Click or drop here" option="paramName:picture|maxFilesize:2|acceptedFiles:image/*" />
                            <x-interface.dropzone :action="route('profile.update.banner')" :put="true" id="banner" title="Banner"
                                message="Click or drop here" option="paramName:banner|maxFilesize:2|acceptedFiles:image/*" />
                        </div>
                    </div>
                </div>
            @endcan
        </x-slot>
    </x-layouts.dashboard.app>
@endcan
