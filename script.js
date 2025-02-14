console.log('scrolling');
window.onscroll = function () {
    const header = document.querySelector('header');
    if (window.scrollY > 100) {
        console.log('scrolling');
        header.classList.add('sticky');
    } else {
        header.classList.remove('sticky');
    }
};