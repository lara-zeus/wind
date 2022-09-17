<div>
    <x-slot name="header">
        <h2>{{ __('Contact us') }}</h2>
    </x-slot>

    <x-zeus::box shadowless class="max-w-4xl mx-auto text-gray-500 text-sm">
        {{ __('feel free to contact us.') }}
    </x-zeus::box>

    <livewire:contact-form :departmentSlug="$departmentSlug" />
</div>
