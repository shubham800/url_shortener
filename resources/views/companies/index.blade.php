<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Companies') }} | <x-nav-link :href="route('companies.create')" :active="request()->routeIs('companies.create')">{{__('Create')}}</x-nav-link>
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-sm font-semibold text-gray-700">Name</th>
                                <th class="px-6 py-3 text-sm font-semibold text-gray-700">Slug</th>
                                <th class="px-6 py-3 text-sm font-semibold text-gray-700">Created On</th>
                                <th class="px-6 py-3 text-sm font-semibold text-gray-700">User Count</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($companies as $company)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-3" style="text-align: center;">{{ $company->name }}</td>
                                    <td class="px-6 py-3 text-gray-600" style="text-align: center;">{{ $company->slug }}</td>
                                    <td class="px-6 py-3" style="text-align: center;">{{ $company->created_at->format('d M y') }}</td>
                                    <td class="px-6 py-3" style="text-align: center;">{{ $company->user_count }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500" style="text-align: center;">
                                        No companies found
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