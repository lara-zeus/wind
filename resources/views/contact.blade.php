<div>
    <x-slot name="title">
        Contact us
    </x-slot>
    <x-slot name="header">
        <h2>Contact us</h2>
    </x-slot>

    <x-zeus::box shadowless class="max-w-4xl mx-auto">
        <div class="text-gray-400 text-sm">
            feel free to contact us.
        </div>
    </x-zeus::box>

    @if($sent)
        @include('zeus-wind::submitted')
    @else
        <form wire:submit.prevent="store">
            @if(config('zeus-wind.enableCategories'))
                @if($categories->isEmpty())
                    <input type="hidden" name="category_id" wire:model="category_id" value="1">
                @else
                    @if($categories->count() > 1)
                        <div class="max-w-4xl mx-auto text-primary-600 -mb-4 mt-4">
                            Select Category:
                            @error('category_id') <p class="text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div class="max-w-4xl mx-auto my-6 grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-2 ">
                            @foreach($categories as $category)
                                <div>
                                    <label class="checkbox-wrapper">
                                        <input wire:model="category_id" type="radio" class="checkbox-input" name="group" value="{{ $category->id }}"/>
                                        <span class="checkbox-tile hover:border-secondary-500 p-4">
                                        <span class="text-primary-600 flex flex-col items-center justify-center gap-2">
                                            <img class="w-full h-32 object-center object-cover" src="{{ asset('storage/'.$category->logo) }}">
                                            {{ $category->name ?? '' }}
                                        </span>
                                        <span class="text-gray-500 text-center px-2 overflow-clip overflow-hidden ">{{ $category->desc ?? '' }}</span>
                                    </span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="max-w-4xl mx-auto text-primary-600 my-4">
                            Sending to:
                            <span class="text-secondary-500 font-semibold">{{ $categories->first()->name ?? '' }}</span>
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
                <x-zeus::elements.button type="submit" class="g-recaptcha">Send</x-zeus::elements.button>
            </div>

        </form>
    @endif

</div>