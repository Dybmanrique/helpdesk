document.addEventListener('livewire:initialized', () => {
    Livewire.on('resetInputs', () => {
        resetInputs();
    });
    Livewire.on('resetApplicantInformationForm', () => {
        resetApplicantInformationForm();
    });
    Livewire.on('confirmApplicantInformation', async (eventData) => {
        const data = eventData[0];
        if(await confirmationMessage(data.title,data.message)){
            Livewire.dispatch('applicantInformationConfirmed', {isConfirmed: true});
        }
    });
})


function resetInputs() {
    document.getElementById('procedure_category_id').value = '';
    document.getElementById('document_type_id').value = '';
    document.getElementById('reason').value = '';
    document.getElementById('description').value = '';
    document.getElementById('files').value = '';
}
function resetApplicantInformationForm() {
    document.getElementById('identityTypeId').value = '';
    document.getElementById('identityNumber').value = '';
    document.getElementById('lastName').value = '';
    document.getElementById('secondLastName').value = '';
    document.getElementById('name').value = '';
    document.getElementById('email').value = '';
    document.getElementById('phone').value = '';
    document.getElementById('address').value = '';
    document.getElementById('ruc').value = '';
    document.getElementById('companyName').value = '';
}
