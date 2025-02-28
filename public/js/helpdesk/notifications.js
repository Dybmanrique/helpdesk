var Toast = Swal.mixin({
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

document.addEventListener('livewire:init', () => {
    Livewire.on('notify', (eventData) => {
        const data = eventData[0];
        if (data.code == 200) {
            Toast.fire({
                icon: 'success',
                title: data.message
            });
        } else if (data.code == 500) {
            Toast.fire({
                icon: 'warning',
                title: data.message
            });
        } else if (data.code == 201) {
            Swal.fire({
                icon: "info",
                title: data.title ?? '',
                html: data.message
            });
        }
    });
});
