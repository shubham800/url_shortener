<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Invite') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            
                <form method="POST" action="{{ route('invitations.store') }}" class="space-y-5">
                    @csrf

                    <div style="display:flex;justify-content: space-evenly;align-items: end;">
                    
                        <div>
                            <label>Name</label><br>
                            <input 
                                type="text" 
                                name="name" 
                                value="{{ old('name') }}" 
                                placeholder="User Name"
                                class=" border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                            >
                        </div>

                        <div>
                            <label>Email</label><br>
                            <input 
                                type="email" 
                                name="email" 
                                value="{{ old('email') }}" 
                                placeholder="ex. sample@example.com" 
                                required
                            >
                        </div>

                        <div>
                            <label>Role</label><br>
                            <select name="role" required>
                                <option value="">-- Select Role --</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>
                                        {{ $role }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            {{-- Company selection --}}
                            @if(auth()->user()->isSuperAdmin())
                                <label>Company</label><br>
                                <select name="company_id" required>
                                    <option value="">-- Select Company --</option>
                                    @foreach($companies as $company)
                                        <option 
                                            value="{{ $company->id }}"
                                            {{ old('company_id', request('company_id')) == $company->id ? 'selected' : '' }}
                                        >
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                {{-- Company is fixed for Admin --}}
                                <input type="hidden" name="company_id" value="{{ auth()->user()->company_id }}">
                                <p>Company: <strong>{{ auth()->user()->company->name }}</strong></p>
                            @endif
                        </div>

                        <div>
                            <button type="submit" class="px-5 py-2 bg-indigo-600 rounded-lg hover:bg-indigo-700 transition" style="border: 1px solid;">Send Invitation</button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>