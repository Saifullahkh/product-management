document.addEventListener('DOMContentLoaded', function () {
    const permissionModal = document.getElementById('addPermission');
    if (!permissionModal) return;

    const modalTitle = document.getElementById('permissionTitle');
    const permissionId = document.getElementById('permissionId');
    const permissionUpdate = document.getElementById('permissionUpdate'); // <input name="_method">
    const permissionNameInput = document.getElementById('permissionNameInput');
    const permissionSubmitBtn = document.getElementById('permissionSubmitBtn');
    const permissionForm = document.getElementById('permissionForm');

    permissionModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button && button.getAttribute ? button.getAttribute('data-id') : null;
        const name = button && button.getAttribute ? button.getAttribute('data-name') : '';

        if (id) {
            modalTitle.textContent = 'Edit Permission';
            permissionId.value = id;
            permissionNameInput.value = name || '';
            permissionUpdate.value = 'PUT';
            permissionSubmitBtn.textContent = 'Update';
            if (permissionForm) permissionForm.action = '/permission/edit/' + id;
        } else {
            modalTitle.textContent = 'Add New Permission';
            permissionId.value = '';
            permissionNameInput.value = '';
            permissionUpdate.value = 'POST';
            permissionSubmitBtn.textContent = 'Submit';
            if (permissionForm) {
                permissionForm.action = '/permission/store';
                if (typeof permissionForm.reset === 'function') permissionForm.reset();
            }
        }
    });

    permissionModal.addEventListener('hidden.bs.modal', function () {
        modalTitle.textContent = 'Add New Permission';
        permissionId.value = '';
        permissionNameInput.value = '';
        permissionUpdate.value = 'POST';
        permissionSubmitBtn.textContent = 'Submit';
        if (permissionForm && typeof permissionForm.reset === 'function') permissionForm.reset();
    });

    // Prevent anchor navigation for edit buttons and open modal programmatically
    document.body.addEventListener('click', function (e) {
        const el = e.target.closest && e.target.closest('a[data-bs-target="#addPermission"][data-id]');
        if (el) {
            e.preventDefault();
            const id = el.getAttribute('data-id');
            const name = el.getAttribute('data-name') || '';

            modalTitle.textContent = 'Edit Permission';
            permissionId.value = id;
            permissionNameInput.value = name;
            permissionUpdate.value = 'PUT';
            permissionSubmitBtn.textContent = 'Update';
            if (permissionForm) permissionForm.action = '/permission/edit/' + id;

            const modal = bootstrap.Modal.getOrCreateInstance(permissionModal);
            modal.show();
        }
    });
});