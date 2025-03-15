document.addEventListener('livewire:initialized', () => {
    Livewire.on('resetInputs', () => {
        resetInputs();
    });
})

function resetInputs() {
    document.getElementById('procedure_category_id').value = '';
    document.getElementById('document_type_id').value = '';
    document.getElementById('reason').value = '';
    document.getElementById('description').value = '';
    document.getElementById('files').value = '';
}