<div>
    <x-slot name="header">
        <h2>{{ __('zeus-wind::wind.contact_us_1') }}</h2>
    </x-slot>

    <x-slot name="breadcrumbs">
        <li class="flex items-center">
            {{ __('zeus-wind::wind.contact_us_1') }}
        </li>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <x-filament::section>
            {{ __('zeus-wind::wind.feel_free_to_contact_us') }}
        </x-filament::section>
    </div>

    @if($sent)
        @include(app('windTheme').'.submitted')
    @else
        <form wire:submit.prevent="store">
            <div class="max-w-4xl mx-auto my-4 px-4">
                {{ $this->form }}
                <div class="p-4 text-center">
                    <x-filament::button type="submit">
                        {{ __('zeus-wind::wind.send') }}
                    </x-filament::button>
                </div>
            </div>
        </form>
    @endif
</div>
