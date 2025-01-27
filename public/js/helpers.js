function fadeOut(element, duration = 1000) {
    element.style.opacity = 1;
    element.style.transition = `opacity ${duration}ms ease`;

    element.style.opacity = 0;
    setTimeout(() => {
        element.style.display = 'none';
    }, duration);
}

function fadeIn(element, duration = 1000) {
    element.style.opacity = 0;
    element.style.transition = `opacity ${duration}ms ease`;

    element.style.opacity = 1;
    setTimeout(() => {
        element.style.display = 'block';
    }, duration);
}