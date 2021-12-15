<div>
    <x-slot name="title">
        Reply to Letter
    </x-slot>

    <x-slot name="header">
        <h2>Reply to Letter</h2>
    </x-slot>

    <x-slot name="breadcrumb">
        <x-zeus::layouts.breadcrumb-item :label="'Reply to Letter'"/>
    </x-slot>

    <x-zeus::box>
        <div class="space-y-10">
            <div class="flex flex-row items-stretch gap-4">
                <div class="w-1/4">
                    <label class="text-gray-500 text-sm">Reply To:</label>
                    <p class="flex flex-col">
                        <span>{{ $letter->name }}</span>
                        <span class="text-sm">({{ $letter->email }})</span>
                    </p>
                </div>
                <div class="w-3/4">
                    <label class="text-gray-500 text-sm">Letter:</label>
                    <p>{{ nl2br($letter->message) }}</p>
                </div>
            </div>

            <div class="space-y-6">
                <x-zeus::input.group inline for="letter.reply_title" label="Reply Title" :error="$errors->first('letter.reply_title')">
                    <x-zeus::input.text wire:model="letter.reply_title"/>
                </x-zeus::input.group>
                <x-zeus::input.group inline for="letter.reply_message" label="Reply Message" :error="$errors->first('letter.reply_message')">
                    <x-zeus::input.textarea wire:model="letter.reply_message"/>
                </x-zeus::input.group>

                <div class="text-center">
                    <x-zeus::elements.button type="button" wire:click="send">Send</x-zeus::elements.button>
                </div>

            </div>
        </div>
    </x-zeus::box>
</div>