jQuery(window).load(function () {
    //Preloader
    setTimeout("jQuery('#preloader').animate({'opacity' : '0'},300,function(){jQuery('#preloader').hide()})", 800);
    setTimeout("jQuery('.preloader_hide, .selector_open').animate({'opacity' : '1'},500)", 800);

});


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