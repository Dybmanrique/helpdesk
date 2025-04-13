window.Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    customClass: {
        popup: 'custom-toast',
        title: 'custom-title',
        timerProgressBar: 'custom-progress'
    }
});

document.addEventListener('livewire:initialized', () => {
    Livewire.on('notify', (eventData) => {
        const data = eventData[0];
        if (data.code == 200) {
            Toast.fire({
                icon: 'success',
                title: data.message
            });
        } else if (data.code == 500) {
            Toast.fire({
                icon: 'info',
                title: data.message
            });
        }
    });
});

function confirmationMessage(title = "¿Está seguro?", text = "Esta operación es irreversible", icon = "warning") {
    return Swal.fire({
        title: title,
        text: text,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "SÍ, ELIMINAR!",
        cancelButtonText: "CANCELAR",
        customClass: {
            container: 'swal2-dark'
        }
    }).then((result) => result.isConfirmed);
}