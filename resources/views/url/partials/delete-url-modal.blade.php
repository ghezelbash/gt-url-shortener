<x-modal name="delete-url-{{$uuid}}" focusable>
    <form method="post" action="{{ route('urls.destroy', $uuid) }}" class="m-6 space-y-6">
        @csrf
        @method('delete')

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Are you sure you want to delete this URL?') }}
        </h2>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ms-3">
                {{ __('Delete URL') }}
            </x-danger-button>
        </div>
    </form>
</x-modal>
