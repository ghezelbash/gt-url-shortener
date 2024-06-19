<header>
    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        {{ __('Add New URL') }}
    </h2>

    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Add your URL you want to be shorten here:') }}
    </p>
</header>
<div class="max-w-xl">
    <form method="post" action="{{ route('urls.store') }}" class="mt-6 flex items-end">
        @csrf
        <div class="flex-grow">
            <x-input-label for="original_url" :value="__('Original URL')"/>
            <x-text-input id="original_url" name="original_url" type="text"
                          class="mt-1 block w-full" placeholder="Enter a link to shorten"
                          autocomplete="original_url"/>
        </div>
        <x-primary-button class="ml-4 h-10">{{ __('Shorten') }}</x-primary-button>
    </form>
    <x-input-error :messages="$errors->first()" class="mt-2" />
</div>
