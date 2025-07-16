var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
});

document.addEventListener('livewire:initialized', () => {
    Livewire.on('notify', (eventData) => {
        let appTheme = localStorage.getItem("theme") === "auto"
            ? (window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light")
            : localStorage.getItem("theme");
        const data = eventData[0];
        if (data.code == 200) {
            Toast.fire({
                icon: 'success',
                title: data.message,
                background: appTheme === "dark" ? "#374151" : "#fff",
                color: appTheme === "dark" ? "#e5e7eb" : "#333",
            });
        } else if (data.code == 500) {
            Toast.fire({
                icon: 'warning',
                title: data.message,
                background: appTheme === "dark" ? "#374151" : "#fff",
                color: appTheme === "dark" ? "#e5e7eb" : "#333",
            });
        } else if (data.code == 201) {
            Swal.fire({
                icon: "info",
                title: data.title ?? '',
                html: data.message,
                customClass: {
                    popup: 'rounded-lg dark:bg-gray-800 dark:text-gray-200 shadow-lg',
                }
            });
        }
    });
});

function confirmationMessage(title = "¿Está seguro?", message = "Esta operación es irreversible", icon = "warning") {
    return Swal.fire({
        title: title,
        html: message,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "CONTINUAR",
        cancelButtonText: "CANCELAR",
        customClass: {
            popup: 'rounded-lg dark:bg-gray-800 dark:text-gray-200 shadow-lg',
            title: 'text-xl',
            htmlContainer: 'text-left text-sm',
        }
    }).then((result) => result.isConfirmed);
}