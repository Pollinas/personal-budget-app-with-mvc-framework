// MOTIVATIONAL STUFF PANEL
const floating_btn = document.querySelector('.floating-btn');
const close_btn = document.querySelector('.close-btn');
const motivation_panel_container = document.querySelector('.motivation-panel-container');

floating_btn.addEventListener('click', () => {
    motivation_panel_container.classList.toggle('visible')
});

close_btn.addEventListener('click', () => {
    motivation_panel_container.classList.remove('visible')
});

