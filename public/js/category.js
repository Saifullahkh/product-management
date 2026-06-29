document.addEventListener('DOMContentLoaded', function () {
    const categoryModal = document.getElementById('addCategoryModal');
    const modalTitle = document.getElementById('categoryModalTitle');
    const categoryId = document.getElementById('categoryId');
    const categoryUpdate = document.getElementById('categoryUpdate'); // <input name="_method">
    const categoryNameInput = document.getElementById('categoryNameInput');
    const categorySubmitBtn = document.getElementById('categorySubmitBtn');
    const categoryForm = document.getElementById('categoryForm');

    categoryModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const name = button.getAttribute('data-name');

        if (id) {
            modalTitle.textContent = 'Edit Category';
            categoryId.value = id;
            categoryNameInput.value = name || '';
            
            // Lahaza yahan 'PUT' ko capital karein taake Laravel samajh sake
            categoryUpdate.value = 'PUT'; 
            categoryForm.action = '/edit-category/' + id;
            categorySubmitBtn.textContent = 'Update Category';
        } else {
            modalTitle.textContent = 'Add New Category';
            categoryId.value = '';
            categoryNameInput.value = '';
            
            // Add ke waqt isko 'POST' rakhein
            categoryUpdate.value = 'POST';
            categoryForm.action = '/add-category';
            categorySubmitBtn.textContent = 'Save Category';
        }
    });
});