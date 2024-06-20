<div class="mt-6">
    @if($urls)
        <div class="flex flex-col space-y-2">
            <div class="flex justify-between bg-gray-200 dark:bg-gray-700 p-2 rounded">
                <div class="w-3/6 font-semibold text-gray-700 dark:text-gray-300">Original URL</div>
                <div class="w-2/6 font-semibold text-gray-700 dark:text-gray-300">Shortened URL</div>
                <div class="w-1/6 font-semibold text-gray-700 dark:text-gray-300">Actions</div>
            </div>
            @foreach ($urls as $url)
                <div class="font-mono flex justify-between items-center bg-gray-100 dark:bg-gray-900 p-2 rounded">
                    <div class="w-3/6 text-gray-900 dark:text-gray-100 truncate" title="{{ $url->original_url }}">{{ $url->original_url }}</div>
                    <div class="w-2/6 text-gray-900 dark:text-gray-100 truncate">
                        <a href="{{ $url->shortened_url }}" class="text-blue-600 dark:text-blue-400">{{ $url->shortened_url }}</a>
                    </div>
                    <div class="w-1/6 flex items-center space-x-4">
                        <i class="fas fa-copy cursor-pointer text-gray-600 dark:text-gray-400" onclick="copyToClipboard('{{ $url->shortened_url }}', this)"></i>
                        <i class="fas fa-edit cursor-pointer text-gray-600 dark:text-gray-400" x-data="" x-on:click.prevent="$dispatch('open-modal', 'edit-url-{{$url->uuid}}')"></i>
                        <i class="fas fa-trash cursor-pointer text-red-600 dark:text-red-400" x-data="" x-on:click.prevent="$dispatch('open-modal', 'delete-url-{{$url->uuid}}')"></i>
                    </div>
                </div>
                @include('url.partials.edit-url-modal', ['uuid' => $url->uuid, 'original_url' => $url->original_url])
                @include('url.partials.delete-url-modal', ['uuid' => $url->uuid])
            @endforeach
        </div>
    @endif
</div>
<script>
    function copyToClipboard(url, icon) {
        navigator.clipboard.writeText(url).then(function() {
            const originalIcon = icon.className;
            icon.className = 'fas fa-check text-green-500';
            setTimeout(() => {
                icon.className = originalIcon;
            }, 2000);
        }, function(err) {
            console.error('Could not copy text: ', err);
        });
    }
</script>
