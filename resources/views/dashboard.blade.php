<div>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <h1>user: {{ Auth::user()->name }}</h1>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger">
            Logout
        </button>
    </form>
    <table border="1" style="border-collapse: collapse; width: 200px;">
        <tr>
            <td>Name</td>
        </tr>
        @foreach ($users as $user)
        <tr>
            <td>{{ $user["name"] }}</td>
        </tr>
        @endforeach
    </table>
</div>
