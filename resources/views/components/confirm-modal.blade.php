<dialog id="confirm-dialog"
        class="m-auto w-full max-w-md rounded-xl border border-slate-200 bg-white p-0 shadow-xl backdrop:bg-slate-900/50">
    <div class="p-6">
        <div class="flex items-start gap-4">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-red-100 text-red-600">
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 6a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 6Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                </svg>
            </div>

            <div>
                <h2 id="confirm-title" class="text-base font-semibold text-slate-900"></h2>
                <p id="confirm-message" class="mt-1 text-sm text-slate-500"></p>
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-2">
            <button type="button" id="confirm-cancel"
                    class="rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-slate-300">
                Batal
            </button>
            <button type="button" id="confirm-ok"
                    class="rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300">
                Ya, hapus
            </button>
        </div>
    </div>
</dialog>

<script>
    (() => {
        const dialog = document.getElementById('confirm-dialog');
        const titleEl = document.getElementById('confirm-title');
        const messageEl = document.getElementById('confirm-message');
        let pendingForm = null;

        // Satu listener untuk semua form yang punya atribut data-confirm.
        document.addEventListener('submit', (event) => {
            const form = event.target;

            if (!(form instanceof HTMLFormElement) || !form.dataset.confirm) {
                return;
            }

            event.preventDefault();

            pendingForm = form;
            titleEl.textContent = form.dataset.confirmTitle || 'Hapus data?';
            messageEl.textContent = form.dataset.confirm;

            dialog.showModal();
            document.getElementById('confirm-cancel').focus();
        });

        document.getElementById('confirm-cancel').addEventListener('click', () => dialog.close());

        document.getElementById('confirm-ok').addEventListener('click', () => {
            const form = pendingForm;
            pendingForm = null;
            dialog.close();

            // form.submit() tidak memicu event submit lagi, jadi tidak muncul modal dua kali.
            form?.submit();
        });

        // Klik area gelap di luar kotak = batal. Escape sudah ditangani <dialog>.
        dialog.addEventListener('click', (event) => {
            if (event.target === dialog) {
                dialog.close();
            }
        });

        dialog.addEventListener('close', () => {
            pendingForm = null;
        });
    })();
</script>