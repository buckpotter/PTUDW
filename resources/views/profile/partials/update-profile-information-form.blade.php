<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Hồ sơ người dùng') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Chỉnh sửa hồ sơ của bạn và địa chỉ email.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Họ tên')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="email" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-gray-800">
                    {{ __('Bạn chưa xác thực email.') }}

                    <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Gửi lại email xác thực.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                <p class="mt-2 font-medium text-sm text-green-600">
                    {{ __('Một đường dẫn xác thực mới đã được gửi đến địa chỉ email của bạn.') }}
                </p>
                @endif
            </div>
            @endif
        </div>

        <div>
            <x-input-label for="IdNX" :value="__('Mã nhà xe')" />
            <x-text-input id="IdNX" name="IdNX" type="text" class="mt-1 block w-full" :value="old('IdNX', $user->IdNX)" required autofocus autocomplete="IdNX" />
            <x-input-error class="mt-2" :messages="$errors->get('IdNX')" />
        </div>

        <div>
            <x-input-label for="sdt" :value="__('Số điện thoại')" />
            <x-text-input id="sdt" name="sdt" type="text" class="mt-1 block w-full" :value="old('sdt', $user->sdt)" required autofocus autocomplete="sdt" />
            <x-input-error class="mt-2" :messages="$errors->get('sdt')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Lưu') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">{{ __('Lưu.') }}</p>
            @endif
        </div>
    </form>
</section>