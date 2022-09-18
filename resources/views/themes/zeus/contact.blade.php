<div>
    <x-slot name="header">
        <h2>{{ __('Contact us') }}</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <x-zeus::box shadowless class="mx-4 text-gray-500 dark:text-gray-100 text-sm">
            {{ __('feel free to contact us.') }}
        </x-zeus::box>
    </div>

    <livewire:contact-form :departmentSlug="$departmentSlug" />
</div>
