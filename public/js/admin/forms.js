export class Forms {
    static clearErrors(formId) {
        const form = document.getElementById(formId)
        if (form) {
            const invalidInputs = form.querySelectorAll('.is-invalid');
            invalidInputs.forEach(input => {
                input.classList.remove('is-invalid');
            });

            const errorMessages = document.querySelectorAll('.invalid-feedback');
            errorMessages.forEach(div => {
                div.remove();
            });
        }
    }

    static showErrors(result) {
        Object.keys(result.errors).forEach(field => {
            const inputElement = document.getElementById(field);
            if (inputElement) {
                inputElement.classList.add('is-invalid');

                const errorDiv = document.createElement('div');
                errorDiv.classList.add('invalid-feedback');
                errorDiv.textContent = result.errors[field][0];

                inputElement.parentNode.appendChild(errorDiv);
            }
        });
    }

    static disableForm(formId) {
        const formulario = document.getElementById(formId);
        if (formulario) {
            const campos = formulario.querySelectorAll('input, select, textarea, button');
            campos.forEach(campo => {
                campo.disabled = true;
            });
        }
    }

    static enableForm(formId) {
        const formulario = document.getElementById(formId);
        if (formulario) {
            const campos = formulario.querySelectorAll('input, select, textarea, button');
            campos.forEach(campo => {
                campo.disabled = false;
            });
        }
    }

}

// Buttons.js
export class Buttons {
    constructor(button) {
        this.button = button;
        this.originalText = button.innerHTML;
    }

    showLoad(text = 'Cargando...') {
        this.button.disabled = true;
        this.button.innerHTML = `
      <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
      ${text}
    `;
    }

    reset() {
        this.button.disabled = false;
        this.button.innerHTML = this.originalText;
    }
}
