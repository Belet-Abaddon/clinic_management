<section>
    <header>
        <h2 class="text-lg font-bold text-gray-900 uppercase tracking-wide">
            {{ __('Patient Information') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Ensure your contact details and address are up to date for medical records.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-8 space-y-6">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <x-input-label for="name" :value="__('Full Name')" class="font-bold" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full rounded-xl border-black-600" :value="old('name', $user->name)" required autofocus />
                <x-input-error class="mt-2 border-black-600 p-3" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Email Address')" class="font-bold" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full rounded-xl border-black-600" :value="old('email', $user->email)" required />
                <x-input-error class="mt-2 border-black-600 p-3" :messages="$errors->get('email')" />
            </div>

            <div>
                <x-input-label for="phone" :value="__('Phone Number')" class="font-bold" />
                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full rounded-xl border-black-600" :value="old('phone', $user->phone)" placeholder="e.g. +63 912 345 6789" />
                <x-input-error class="mt-2 border-black-600 p-3" :messages="$errors->get('phone')" />
            </div>

            <div>
                <x-input-label for="date_of_birth" :value="__('Date of Birth')" class="font-bold" />
                <x-text-input id="date_of_birth" name="date_of_birth" type="date" class="mt-1 block w-full rounded-xl border-black-600" :value="old('date_of_birth', $user->date_of_birth)" />
                <x-input-error class="mt-2 border-black-600 p-3" :messages="$errors->get('date_of_birth')" />
            </div>

            <div class="md:col-span-2">
                <x-input-label for="address" :value="__('Residential Address')" class="font-bold" />
                <textarea id="address" name="address" rows="3" class="mt-1 block w-full border-black-600 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm">{{ old('address', $user->address) }}</textarea>
                <x-input-error class="mt-2 border-black-600 p-3" :messages="$errors->get('address')" />
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4">
            <x-primary-button class="bg-blue-600 hover:bg-blue-700 px-8 py-3 rounded-xl shadow-lg shadow-blue-100">
                {{ __('Update Profile') }}
            </x-primary-button>
        </div>
    </form>
</section>