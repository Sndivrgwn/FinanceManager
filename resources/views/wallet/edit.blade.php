@vite(['resources/css/app.css', 'resources/js/app.js'])

<div class="max-w-xl mx-auto p-6 bg-white shadow-md rounded-lg mt-10">
    <!-- Header Form -->
    <div class="flex justify-between items-center mb-6 border-b pb-4">
        <h1 class="text-xl font-bold text-gray-800">Add New Wallet</h1>
        <a href="/wallets" class="text-sm text-gray-600 hover:text-gray-900 font-medium">
            &larr; Kembali
        </a>
    </div>

    <!-- Form -->
    <form action="/add-wallet" method="POST" class="space-y-4">
        <!-- Jangan lupa token CSRF jika pakai Laravel -->
        <!-- @csrf -->

        <!-- Input Nama Wallet -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Wallet Name</label>
            <input type="text" id="name" name="name" placeholder="Contoh: BCA, Dompet Tunai, OVO" 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
        </div>

        <!-- Input Tipe Wallet -->
        <div>
            <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Wallet Type</label>
            <select id="type" name="type" 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                <option value="" disabled selected>Pilih Tipe Wallet</option>
                <option value="BANK">Bank</option>
                <option value="CASH">Cash (Tunai)</option>
                <option value="E_WALLET">E-Wallet (OVO/GoPay/Dana)</option>
            </select>
        </div>

        <!-- Input Saldo Awal -->
        <div>
            <label for="balance" class="block text-sm font-medium text-gray-700 mb-1">Initial Balance (Saldo Awal)</label>
            <input type="number" id="balance" name="balance" placeholder="0" 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex justify-end space-x-3 pt-4 border-t">
            <a href="/dashboard" class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition">
                Cancel
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                Save Wallet
            </button>
        </div>
    </form>
</div>