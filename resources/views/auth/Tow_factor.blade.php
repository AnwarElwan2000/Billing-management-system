<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Please enter the verification method sent to you .') }}
    </div>

    <form method="POST" action="{{route('tow_factor.store')}}">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Validation code')" />

            <x-text-input id="code" class="block mt-1 w-full"
                            type="text"
                            name="code"
                            required/>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                           <li class="text-danger">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="flex justify-end mt-4">
            <x-primary-button>
                {{ __('تاكيد') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
