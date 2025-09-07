export class Loader {
    static showLoader(loaderId, conentId, show = true) {
        const modalLoader = document.getElementById(loaderId);
        const modalContent = document.getElementById(conentId);
        if (modalLoader && modalContent) {
            if (show) {
                modalLoader.classList.remove('d-none');
                modalContent.classList.add('d-none');
            } else {
                modalLoader.classList.add('d-none');
                modalContent.classList.remove('d-none');
            }
        }
    }
}