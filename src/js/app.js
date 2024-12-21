const mobileMenuBtn = document.querySelector('#mobile-menu');
const sidebar = document.querySelector('.sidebar')

window.addEventListener('resize', e => {
    if(window.innerWidth > 768)
        sidebar.classList.remove('mostrar');
})

mobileMenuBtn?.addEventListener('click', e => {
    sidebar.classList.toggle('mostrar');
})