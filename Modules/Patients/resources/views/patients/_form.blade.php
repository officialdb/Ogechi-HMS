@php
    $patient ??= null;
@endphp

<div class="grid gap-6 lg:grid-cols-2">
    <div>
        <x-input-label for="first_name" :value="__('First Name')" />
        <x-text-input id="first_name" name="first_name" type="text" class="mt-2 block w-full" :value="old('first_name', $patient?->first_name)" required />
        <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
    </div>

    <div>
        <x-input-label for="last_name" :value="__('Last Name')" />
        <x-text-input id="last_name" name="last_name" type="text" class="mt-2 block w-full" :value="old('last_name', $patient?->last_name)" required />
        <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
    </div>

    <div>
        <x-input-label for="middle_name" :value="__('Middle Name')" />
        <x-text-input id="middle_name" name="middle_name" type="text" class="mt-2 block w-full" :value="old('middle_name', $patient?->middle_name)" />
        <x-input-error class="mt-2" :messages="$errors->get('middle_name')" />
    </div>

    <div>
        <x-input-label for="date_of_birth" :value="__('Date of Birth')" />
        <x-text-input id="date_of_birth" name="date_of_birth" type="date" class="mt-2 block w-full" :value="old('date_of_birth', $patient?->date_of_birth?->format('Y-m-d'))" />
        <x-input-error class="mt-2" :messages="$errors->get('date_of_birth')" />
    </div>

    <div>
        <x-input-label for="gender" :value="__('Gender')" />
        <select id="gender" name="gender" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            <option value="">Select gender</option>
            @foreach ($selectOptions['genders'] as $value => $label)
                <option value="{{ $value }}" @selected(old('gender', $patient?->gender) === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('gender')" />
    </div>

    <div>
        <x-input-label for="phone" :value="__('Phone Number')" />
        <x-text-input id="phone" name="phone" type="text" class="mt-2 block w-full" :value="old('phone', $patient?->phone)" required />
        <x-input-error class="mt-2" :messages="$errors->get('phone')" />
    </div>

    <div>
        <x-input-label for="email" :value="__('Email Address')" />
        <x-text-input id="email" name="email" type="email" class="mt-2 block w-full" :value="old('email', $patient?->email)" />
        <x-input-error class="mt-2" :messages="$errors->get('email')" />
    </div>

    <div>
        <x-input-label for="marital_status" :value="__('Marital Status')" />
        <select id="marital_status" name="marital_status" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">Select marital status</option>
            @foreach ($selectOptions['maritalStatuses'] as $value => $label)
                <option value="{{ $value }}" @selected(old('marital_status', $patient?->marital_status) === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('marital_status')" />
    </div>

    <div>
        <x-input-label for="blood_group" :value="__('Blood Group')" />
        <select id="blood_group" name="blood_group" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">Select blood group</option>
            @foreach ($selectOptions['bloodGroups'] as $value => $label)
                <option value="{{ $value }}" @selected(old('blood_group', $patient?->blood_group) === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('blood_group')" />
    </div>

    <div>
        <x-input-label for="genotype" :value="__('Genotype')" />
        <select id="genotype" name="genotype" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">Select genotype</option>
            @foreach ($selectOptions['genotypes'] as $value => $label)
                <option value="{{ $value }}" @selected(old('genotype', $patient?->genotype) === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('genotype')" />
    </div>

    <div class="lg:col-span-2">
        <x-input-label for="address" :value="__('Address')" />
        <textarea id="address" name="address" rows="3" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('address', $patient?->address) }}</textarea>
        <x-input-error class="mt-2" :messages="$errors->get('address')" />
    </div>

    <div>
        <x-input-label for="city" :value="__('City')" />
        <x-text-input id="city" name="city" type="text" class="mt-2 block w-full" :value="old('city', $patient?->city)" />
        <x-input-error class="mt-2" :messages="$errors->get('city')" />
    </div>

    <div>
        <x-input-label for="state" :value="__('State')" />
        <x-text-input id="state" name="state" type="text" class="mt-2 block w-full" :value="old('state', $patient?->state)" />
        <x-input-error class="mt-2" :messages="$errors->get('state')" />
    </div>

    <div>
        <x-input-label for="country" :value="__('Country')" />
        <x-text-input id="country" name="country" type="text" class="mt-2 block w-full" :value="old('country', $patient?->country ?? 'Nigeria')" />
        <x-input-error class="mt-2" :messages="$errors->get('country')" />
    </div>

    <div class="lg:col-span-2">
        <x-input-label for="allergies" :value="__('Allergies')" />
        <textarea id="allergies" name="allergies" rows="3" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('allergies', $patient?->allergies) }}</textarea>
        <x-input-error class="mt-2" :messages="$errors->get('allergies')" />
    </div>

    <div>
        <x-input-label for="next_of_kin_name" :value="__('Next of Kin Name')" />
        <x-text-input id="next_of_kin_name" name="next_of_kin_name" type="text" class="mt-2 block w-full" :value="old('next_of_kin_name', $patient?->next_of_kin_name)" />
        <x-input-error class="mt-2" :messages="$errors->get('next_of_kin_name')" />
    </div>

    <div>
        <x-input-label for="next_of_kin_phone" :value="__('Next of Kin Phone')" />
        <x-text-input id="next_of_kin_phone" name="next_of_kin_phone" type="text" class="mt-2 block w-full" :value="old('next_of_kin_phone', $patient?->next_of_kin_phone)" />
        <x-input-error class="mt-2" :messages="$errors->get('next_of_kin_phone')" />
    </div>

    <div>
        <x-input-label for="next_of_kin_relationship" :value="__('Next of Kin Relationship')" />
        <x-text-input id="next_of_kin_relationship" name="next_of_kin_relationship" type="text" class="mt-2 block w-full" :value="old('next_of_kin_relationship', $patient?->next_of_kin_relationship)" />
        <x-input-error class="mt-2" :messages="$errors->get('next_of_kin_relationship')" />
    </div>

    <div>
        <x-input-label for="emergency_contact_name" :value="__('Emergency Contact Name')" />
        <x-text-input id="emergency_contact_name" name="emergency_contact_name" type="text" class="mt-2 block w-full" :value="old('emergency_contact_name', $patient?->emergency_contact_name)" />
        <x-input-error class="mt-2" :messages="$errors->get('emergency_contact_name')" />
    </div>

    <div>
        <x-input-label for="emergency_contact_phone" :value="__('Emergency Contact Phone')" />
        <x-text-input id="emergency_contact_phone" name="emergency_contact_phone" type="text" class="mt-2 block w-full" :value="old('emergency_contact_phone', $patient?->emergency_contact_phone)" />
        <x-input-error class="mt-2" :messages="$errors->get('emergency_contact_phone')" />
    </div>

    <div class="lg:col-span-2">
        <x-input-label for="notes" :value="__('Notes')" />
        <textarea id="notes" name="notes" rows="4" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes', $patient?->notes) }}</textarea>
        <x-input-error class="mt-2" :messages="$errors->get('notes')" />
    </div>
</div>
