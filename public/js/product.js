document.addEventListener('DOMContentLoaded', function () {
    const productModal = document.getElementById('addProductModal1');
    const modalTitle = document.getElementById('productModalTitle');
    const productId = document.getElementById('productId');
    const productUpdate = document.getElementById('productUpdate');
    const productNameInput = document.getElementById('productNameInput');
    const productCategoryInput = document.getElementById('productCategoryInput');
    const productPriceInput = document.getElementById('productPriceInput');
    const productStockInput = document.getElementById('productStockInput');
    const productImage = document.getElementById('productImage');
    const productSubmitBtn = document.getElementById('productSubmitBtn');
    
    // HTML ke <img> tag ko select kiya previous image dikhane kely
    const imagePreview = document.getElementById('imagePreview');

    productModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');

        if(id){
            modalTitle.textContent = 'Update Product';
            productId.value = id;
            productUpdate.value = '1';
            productNameInput.value = button.getAttribute('data-name') || '';
            productCategoryInput.value = button.getAttribute('data-category_id') || button.getAttribute('data-category') || '';
            productPriceInput.value = button.getAttribute('data-price') || '';
            productStockInput.value = button.getAttribute('data-stock') || '0';
            productSubmitBtn.textContent = 'Update Product';
            
            const imageUrl = button.getAttribute('data-image') || '';
            
            // --- Previous Image Dikhane Ka Logic ---
            if(imageUrl && imagePreview) {
                imagePreview.src = imageUrl;
                imagePreview.style.display = 'block'; // Image show ho jayegi
            } else if(imagePreview) {
                imagePreview.style.display = 'none';
            }
            
        }else{
            modalTitle.textContent = 'Add New Product';
            productId.value = '';
            productUpdate.value = '';
            productNameInput.value = '';
            productCategoryInput.value = '';
            productPriceInput.value = '0';
            productStockInput.value = '0';
            productImage.value = '';
            productSubmitBtn.textContent = 'Save Product';

            // --- Naya product banate waqt image preview ko hide karne kely ---
            if(imagePreview) {
                imagePreview.src = '';
                imagePreview.style.display = 'none'; // Image chhup jayegi
            }
        }
    });
});