document.addEventListener("DOMContentLoaded", function () {
    const loginForm = document.getElementById("login-form");
    const registerForm = document.getElementById("register-form");
    const showRegister = document.getElementById("show-register");
    const showLogin = document.getElementById("show-login");

    function showForm(formToShow, formToHide) {
        formToHide.classList.remove("active");
        setTimeout(() => {
            formToHide.style.display = "none";
            formToShow.style.display = "flex";
            setTimeout(() => {
                formToShow.classList.add("active");
            }, 10);
        }, 300);
    }

    showRegister.addEventListener("click", function (event) {
        event.preventDefault();
        showForm(registerForm, loginForm);
    });

    showLogin.addEventListener("click", function (event) {
        event.preventDefault();
        showForm(loginForm, registerForm);
    });

    // Exibir o formulário de login por padrão
    loginForm.style.display = "flex";
    setTimeout(() => loginForm.classList.add("active"), 10);
});
