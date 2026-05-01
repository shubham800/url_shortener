<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('All URLs') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                <form method="POST" action="{{ route('urls.store') }}" class="space-y-5">
                    @csrf
                    <div style="display: flex;justify-content: center;align-items: end;">
                        <div>
                            <label>Long URL</label>
                            <br>
                            <input type="url"
                                name="original_url"
                                placeholder="e.g. https://google.com/"
                                class=" border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                                required
                                value="{{ old('original_url') }}" 
                                size="60">

                                @error('original_url')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                        </div>

                        <div style="margin-left: 10px;">
                            <button type="submit" class="px-5 py-2 bg-indigo-600 rounded-lg hover:bg-indigo-700 transition" style="border: 1px solid;">Submit</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>