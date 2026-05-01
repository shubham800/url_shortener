<div style="text-align: center;width: 80%;margin: auto;">
    <h2>Accept Invitation</h2>

    <p>
        You have been invited to join: 
        <strong>{{ $invitation->company->name }}</strong>
    </p>
    <p>
        Role assigned: 
        <strong>{{ $invitation->role }}</strong>
    </p>

    <hr>

    @if($errors->any())
        <ul style="color: red;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('invitations.register', $invitation->token) }}">
        @csrf

        <div style="display: flex;justify-content: space-evenly;align-items: end;">
            <div>
                <label>Email</label><br>
                <input type="email" value="{{ $invitation->email }}" disabled>
            </div>
    
            <div>
                <label>Your Name</label><br>
                <input type="text" name="name" value="{{ old('name') }}" required>
            </div>
    
            <div>
                <label>Password</label><br>
                <input type="password" name="password" required>
            </div>
    
            <div>
                <label>Confirm Password</label><br>
                <input type="password" name="password_confirmation" required>
            </div>
    
            <div>
                <button type="submit">Create Account & Join</button>
            </div>
        </div>
    </form>

</div>