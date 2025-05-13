document.addEventListener('DOMContentLoaded', () => {
    window.onscroll = function () {
        const header = document.querySelector('header');
        if (header) {
            if (window.scrollY > 100) {
                header.classList.add('sticky');
            } else {
                header.classList.remove('sticky');
            }
        } else {
            console.warn('Header não encontrado');
        }
    };
});