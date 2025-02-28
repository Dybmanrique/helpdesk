document.addEventListener('livewire:initialized', () => {
    Livewire.on('resetInputs', () => {
        resetInputs();
    });
    Livewire.on('created-notify',(notifyData) =>{
        const data = notifyData[0];
        Swal.fire({
            title: data.title,
            html: data.message,
            icon: "info"
        });
    });
})

function resetInputs() {
    document.getElementById('procedure_category_id').value = '';
    document.getElementById('procedure_priority_id').value = '';
    document.getElementById('document_type_id').value = '';
    document.getElementById('reason').value = '';
    document.getElementById('description').value = '';
    document.getElementById('files').value = '';
}