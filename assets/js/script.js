document.addEventListener('DOMContentLoaded', () => {
    loadHeader();
    loadFooter();
});
// Função para carregar o cabeçalho dinamicamente
/*function loadHeader() {
    fetch('assets/includes/html/header.html')
        .then(response => response.text())
        .then(data => {
            document.getElementById('header').innerHTML = data;
        })
        .catch(error => console.error('Erro ao carregar o cabeçalho:', error));
}*/

// Função para carregar o rodapé dinamicamente
function loadFooter() {
    fetch('assets/includes/html/footer.html')
        .then(response => response.text())
        .then(data => {
            document.getElementById('footer').innerHTML = data;
        })
        .catch(error => console.error('Erro ao carregar o rodapé:', error));
}