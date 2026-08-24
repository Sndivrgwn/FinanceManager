@vite(['resources/css/app.css', 'resources/js/app.js'])

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
    <table class="border">
        <tr>
            <td>Name</td>
        </tr>
        @foreach ($users as $user)
        <tr>
            <td>{{ $user["name"] }}</td>
        </tr>
        @endforeach
    </table>
    <div class="max-w-4xl mx-auto p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Wallet</h1>
            <a href="/add-wallet" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                + Add Wallet
            </a>
        </div>

        <div class="overflow-x-auto shadow-sm rounded-lg border border-gray-200">
            <table class="w-full text-sm text-left text-gray-600 border-collapse">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th scope="col" class="px-6 py-3 font-semibold">Name</th>
                        <th scope="col" class="px-6 py-3 font-semibold">Type</th>
                        <th scope="col" class="px-6 py-3 font-semibold">Balance</th>
                        <th scope="col" class="px-6 py-3 font-semibold text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach ($wallets as $wallet)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $wallet->name }}</td>
                        <td class="px-6 py-4">{{ $wallet->type }}</td>
                        <td class="px-6 py-4"><span>Rp {{ number_format($wallet->balance, 0, ',', '.') }}</span></td>
                        <td class="px-6 py-4 text-center space-x-2">
                            <a href="#" class="text-blue-600 hover:underline font-medium">Edit</a>
                            <span class="text-gray-300">|</span>
                            <a href="#" class="text-red-600 hover:underline font-medium">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
