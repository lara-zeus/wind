<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div x-data="{ state: $wire.entangle('{{ $getStatePath() }}').defer }">
        @if(\LaraZeus\Wind\WindPlugin::get()->hasDepartmentResource())
            @php $departments = \LaraZeus\Wind\WindPlugin::get()->getModel('Department')::departments()->get(); @endphp
            @if($departments->isEmpty())
                <x-filament::section>
                    <div class="text-red-400">
                        {{ __('no departments available!') }}
                    </div>
                </x-filament::section>
                <input type="hidden" name="{{ $getStatePath() }}" wire:model="{{ $getStatePath() }}" value="{{ \LaraZeus\Wind\WindPlugin::get()->getDefaultDepartmentId() }}">
            @else
                <div class="max-w-4xl mx-auto text-primary-600 -mb-4 mt-4">
                    {{ __('Select Department') }}:
                    @error($getStatePath()) <p class="text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="max-w-4xl mx-auto my-6 grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-2 ">
                    @foreach($departments as $dept)
                        <div>
                            <label class="checkbox-wrapper">
                                <input wire:model="{{ $getStatePath() }}" type="radio" class="checkbox-input" name="group" value="{{ $dept->id }}"/>
                                <span class="checkbox-tile hover:border-primary-500 p-4">
                                    <span class="text-primary-600 dark:text-primary-500 flex flex-col items-center justify-center gap-2">
                                        @if($dept->image() !== null)
                                            <img alt="{{ $dept->name ?? '' }}" class="w-full h-32 object-center object-cover" src="{{ $dept->image() }}">
                                        @endif
                                        {{ $dept->name ?? '' }}
                                    </span>
                                    <span class="text-gray-500 dark:text-gray-100 text-center px-2 overflow-clip">{{ $dept->desc ?? '' }}</span>
                                </span>
                            </label>
                        </div>
                    @endforeach
                </div>
            @endif
        @endif
    </div>
</x-dynamic-component>
