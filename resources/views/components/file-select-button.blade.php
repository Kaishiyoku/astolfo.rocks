@props(['name', 'multiple' => false])

<div x-data="fileSelectButton()" class="{{ classNames('flex items-center space-x-2', $attributes->get('class')) }}">
    <input type="file" id="{{ $name }}" name="{{ $name }}" hidden x-ref="fileInputElement" {{ $attributes->except(['class', 'id']) }} @change="handleChange($event)"/>

    <label for="{{ $name }}" class="cursor-pointer inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition">
        {{ __('Choose file' . ($multiple ? 's' : '')) }}
    </label>

    <div class="w-64 overflow-hidden overflow-ellipsis whitespace-nowrap" x-text="fileDescription"></div>
</div>

<script type="text/javascript">
    function fileSelectButton() {
        return {
            fileDescription: '{{ __('No file' . ($multiple ? 's' : '') . ' chosen') }}',
            handleChange(event) {
                const files = event.target.files;
                this.fileDescription = files.length > 1 ? `${files.length} {{ __('Files') }}` : files[0].name;
            },
        };
    }
</script>