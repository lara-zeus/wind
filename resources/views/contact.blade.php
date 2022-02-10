<div>
    <x-slot name="title">
        {{ __('Contact us') }}
    </x-slot>
    <x-slot name="header">
        <h2>{{ __('Contact us') }}</h2>
    </x-slot>

    <x-zeus::box shadowless class="max-w-4xl mx-auto">
        <div class="text-gray-400 text-sm">
            {{ __('feel free to contact us.') }}
        </div>
    </x-zeus::box>

    @if($sent)
        @include('zeus-wind::submitted')
    @else
        <form wire:submit.prevent="store">
            @if(config('zeus-wind.enableDepartments'))
                @if($departments->isEmpty())
                    <input type="hidden" name="department_id" wire:model="department_id" value="1">
                @else
                    @if($departments->count() > 1)
                        <div class="max-w-4xl mx-auto text-primary-600 -mb-4 mt-4">
                            {{ __('Select Department') }}:
                            @error('department_id') <p class="text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div class="max-w-4xl mx-auto my-6 grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-2 ">
                            @foreach($departments as $dept)
                                <div>
                                    <label class="checkbox-wrapper">
                                        <input wire:model="department_id" type="radio" class="checkbox-input" name="group" value="{{ $dept->id }}"/>
                                        <span class="checkbox-tile hover:border-secondary-500 p-4">
                                        <span class="text-primary-600 flex flex-col items-center justify-center gap-2">
                                            @if($dept->logo !== null)
                                                <img class="w-full h-32 object-center object-cover" src="{{ \Illuminate\Support\Facades\Storage::disk(config('zeus-wind.uploads.disk','public'))->url($dept->logo) }}">
                                            @endif
                                            {{ $dept->name ?? '' }}
                                        </span>
                                        <span class="text-gray-500 text-center px-2 overflow-clip overflow-hidden ">{{ $dept->desc ?? '' }}</span>
                                    </span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="max-w-4xl mx-auto text-primary-600 my-4">
                            {{ __('Sending to') }}:
                            <span class="text-secondary-500 font-semibold">{{ $departments->first()->name ?? '' }}</span>
                        </div>
                    @endif
                @endif
            @endif

            <x-zeus::box class="max-w-4xl mx-auto">
                <section class="space-y-4">
                    <div class="flex items-center space-x-4">
                        <div class="w-full">
                            <x-zeus::input.group for="name" inline label="Name" :error="$errors->first('name')">
                                <x-zeus::input.text wire:model="name"></x-zeus::input.text>
                            </x-zeus::input.group>
                        </div>
                        <div class="w-full">
                            <x-zeus::input.group for="email" inline label="Email" :error="$errors->first('email')">
                                <x-zeus::input.text wire:model="email"></x-zeus::input.text>
                            </x-zeus::input.group>
                        </div>
                    </div>
                    <div>
                        <x-zeus::input.group for="title" inline label="Title" :error="$errors->first('title')">
                            <x-zeus::input.text wire:model="title"></x-zeus::input.text>
                        </x-zeus::input.group>
                    </div>
                    <div>
                        <x-zeus::input.group for="message" inline label="Message" :error="$errors->first('message')">
                            <x-zeus::input.textarea wire:model="message"></x-zeus::input.textarea>
                        </x-zeus::input.group>
                    </div>
                </section>
            </x-zeus::box>

            <div class="p-4 text-center">
                <x-zeus::button type="submit" class="g-recaptcha">{{ __('Send') }}</x-zeus::button>
            </div>

        </form>
    @endif

</div>
