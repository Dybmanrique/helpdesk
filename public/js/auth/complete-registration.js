'use strict';

var anyChange = true;
window.onbeforeunload = function (event) {
    if (anyChange) {
        return event.preventDefault();
    }
};

document.getElementById('completeRegistrationForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    const formData = new FormData();
    formData.append('identity_type_id', document.getElementById('identity_type_id').value);
    formData.append('identity_number', document.getElementById('identity_number').value);
    formData.append('name', document.getElementById('name').value);
    formData.append('last_name', document.getElementById('last_name').value);
    formData.append('second_last_name', document.getElementById('second_last_name').value);
    formData.append('phone', document.getElementById('phone').value);
    formData.append('address', document.getElementById('address').value);
    formData.append('ruc', document.getElementById('ruc').value);
    formData.append('company_name', document.getElementById('company_name').value);
    formData.append('email', document.getElementById('email').value);
    formData.append('password', document.getElementById('password').value);
    formData.append('password_confirmation', document.getElementById('password_confirmation').value);

    try {
        const response = await fetch("/completar-registro", {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
        });

        if (response.ok) {
            const result = await response.json();
            anyChange = false; // para evitar que se detenga la redirección
            if (result.success) {
                window.location.replace(result.redirect_to ?? '/');
            }
        } else {
            anyChange = true;
            // Limpiar los errores anteriores
            document.querySelectorAll('.error-list').forEach(function (element) {
                element.remove();
            });
            const result = await response.json();
            showErrors(result.errors);
        }
    } catch (error) {
        console.error('Error al enviar el formulario:', error);
    }
});

// Función para mostrar los errores en el formulario
function showErrors(errors) {
    for (const field in errors) {
        if (errors.hasOwnProperty(field)) {
            const errorMessages = errors[field];
            const errorContainer = document.getElementById(field + '-error-container');
            errorContainer.innerHTML = '';

            if (errorContainer) {
                // Crear un contenedor de errores (ul) con la clase 'error-list'
                const errorList = document.createElement('ul');
                errorList.classList.add('text-sm', 'text-red-600', 'dark:text-red-400', 'space-y-1', 'error-list');

                // Crear los elementos de la lista (li) para cada mensaje de error
                errorMessages.forEach(message => {
                    const li = document.createElement('li');
                    li.textContent = message;
                    errorList.appendChild(li);
                });

                // Insertar la lista de errores en el contenedor correspondiente
                errorContainer.appendChild(errorList);
            }
        }
    }
}
