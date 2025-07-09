document.addEventListener('DOMContentLoaded', () => {
    // Funcionalidade de scroll para sticky header
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

    // Funcionalidade do menu móvel
    const btnOpenMenu = document.querySelector('.btn-open-menu');
    const btnCloseMenu = document.querySelector('.btn-close-menu');
    const header = document.querySelector('#header');

    if (btnOpenMenu && header) {
        btnOpenMenu.addEventListener('click', () => {
            header.classList.add('active');
        });
    }

    if (btnCloseMenu && header) {
        btnCloseMenu.addEventListener('click', () => {
            header.classList.remove('active');
        });
    }

});