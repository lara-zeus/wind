<div>
    <x-slot name="title">
        {{ __('Contact us') }}
    </x-slot>
    <x-slot name="header">
        <h2>{{ __('Contact us') }}</h2>
    </x-slot>

    <x-zeus::box shadowless class="max-w-4xl mx-auto text-gray-500 text-sm">
        {{ __('feel free to contact us.') }}
    </x-zeus::box>

    @if($sent)
        @include('zeus-wind::submitted')
    @else
        <form wire:submit.prevent="store">
            <div class="max-w-4xl mx-auto my-4">
                {{ $this->form }}

                <div class="p-4 text-center">
                    <x-zeus::button type="submit">{{ __('Send') }}</x-zeus::button>
                </div>
            </div>

        </form>
    @endif

</div>
