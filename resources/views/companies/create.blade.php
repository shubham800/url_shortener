<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Companies') }} | <x-nav-link :href="route('companies.index')" :active="request()->routeIs('companies.index')">{{__('List')}}</x-nav-link>
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            
                <form method="POST" action="{{ route('companies.store') }}" class="space-y-5">
                    @csrf
                    <div style="text-align: center">

                        <input type="text"
                            name="name"
                            placeholder="Company Name"
                            class=" border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                            required
                            value="{{ old('name') }}">

                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                        <button type="submit" class="px-5 py-2 bg-indigo-600 rounded-lg hover:bg-indigo-700 transition" style="border: 1px solid;">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>