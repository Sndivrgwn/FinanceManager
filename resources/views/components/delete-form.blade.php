@props(['action', 'message' => 'Yakin ingin menghapus data ini?', 'title' => 'Hapus data?', 'size' => 'sm'])

<form action="{{ $action }}" method="POST" class="inline"
      data-confirm="{{ $message }}" data-confirm-title="{{ $title }}">
    @csrf
    @method('DELETE')

    <x-button type="submit" variant="danger" :size="$size">Hapus</x-button>
</form>