@props(['resource', 'model', 'message' => 'Yakin ingin menghapus data ini?'])

<div class="flex justify-end gap-2">
    <x-button :href="route($resource . '.show', $model)" variant="secondary" size="sm">Detail</x-button>
    <x-button :href="route($resource . '.edit', $model)" variant="secondary" size="sm">Edit</x-button>
    <x-delete-form :action="route($resource . '.destroy', $model)" :message="$message" />
</div>