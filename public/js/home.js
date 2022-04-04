jQuery(window).load(function () {
    //Preloader
    setTimeout("jQuery('#preloader').animate({'opacity' : '0'},300,function(){jQuery('#preloader').hide()})", 800);
    setTimeout("jQuery('.preloader_hide, .selector_open').animate({'opacity' : '1'},500)", 800);

});

//not logged users - stack of cards

$(document).ready(function () {

    let content = $('.content');
    let currentItem = content.filter('.active');
    let steps = $('.card').filter('.steps');
    let inactive1 = $('.inactive-1');
    let inactive2 = $('.inactive-2');

    $('.button').click(function () {
        let nextItem = currentItem.next();
        let lastItem = content.last();
        let contentFirst = content.first();

        currentItem.removeClass('active');

        if (currentItem.is(lastItem)) {
            currentItem = contentFirst.addClass('active');
            currentItem.css({ 'right': '10%', 'opacity': '1' });
            $('.step').animate({ width: '33%' });
            inactive1.animate({ height: '8px', marginLeft: '20px', marginRight: '20px' }, 100);
            inactive2.animate({ height: '8px', marginLeft: '10px', marginRight: '10px' }, 100);

        } else if (currentItem.is(contentFirst)) {
            currentItem.animate({ opacity: 0 }, 1000);
            currentItem = nextItem.addClass('active');
            $('.step').animate({ width: '66%' });
            inactive2.animate({ height: '0', marginLeft: '0px', marginRight: '0px' }, 100);

        } else {
            currentItem = nextItem.addClass('active');
            $('.step').animate({ width: '100%' });
            inactive1.animate({ height: '0', marginLeft: '0px', marginRight: '0px' }, 100);
        }
    });

});

