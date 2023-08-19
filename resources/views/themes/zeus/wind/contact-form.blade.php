<div>
    <x-slot name="header">
        <h2>{{ __('Contact us') }}</h2>
    </x-slot>

    <x-slot name="breadcrumbs">
        <li class="flex items-center">
            <a href="{{ url('/') }}">{{ __('Home') }}</a>
            @svg('iconpark-rightsmall-o','fill-current w-4 h-4 mx-3 rtl:rotate-180')
        </li>

        <li class="flex items-center">
            {{ __('Contact us') }}
        </li>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <x-filament::section>
            {{ __('feel free to contact us.') }}
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
                        {{ __('Send') }}
                    </x-filament::button>
                </div>
            </div>
        </form>
    @endif
</div>
