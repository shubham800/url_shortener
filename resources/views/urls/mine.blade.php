<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('All URLs') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-sm font-semibold text-gray-700">Short URL</th>
                                <th class="px-6 py-3 text-sm font-semibold text-gray-700">Long URL</th>
                                <th class="px-6 py-3 text-sm font-semibold text-gray-700">Hits</th>
                                <th class="px-6 py-3 text-sm font-semibold text-gray-700">Created On</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($urls as $url)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-3" style="text-align: center;">
                                        <a href="{{ route('urls.resolve', $url->short_code) }}" target="_blank">
                                            {{ url('/s/' . $url->short_code) }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-3 text-gray-600" style="text-align: center;">{{ Str::limit($url->original_url, 50) }}</td>
                                    <td class="px-6 py-3" style="text-align: center;">{{ $url->hits }}</td>
                                    <td class="px-6 py-3" style="text-align: center;">{{ $url->created_at->format('d M y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500" style="text-align: center;">
                                        No URLs found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>