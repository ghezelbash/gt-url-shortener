<x-modal name="edit-url-{{$uuid}}" focusable>
    <form method="post" action="{{ route('urls.update', $uuid) }}" class="m-6 space-y-6">
        @csrf
        @method('put')
        <div>
            <x-input-label for="original_url" :value="__('Original URL')"/>
            <x-text-input id="original_url" name="original_url" type="url"
                          class="mt-1 block w-full" placeholder="Enter a link"
                          autocomplete="original_url" required value="{{ $original_url }}"/>
        </div>
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Update') }}</x-primary-button>
        </div>
    </form>
</x-modal>
