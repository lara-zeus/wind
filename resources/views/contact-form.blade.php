<div>
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
