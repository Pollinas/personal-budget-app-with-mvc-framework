/**
 * Multi-step form animations.
 */
var current_fs, next_fs, previous_fs; // fieldsets
var left, opacity, scale; // fieldset properties which we will animate
var animating; // flag to prevent quick multi-click glitches

/**
 * On clicking "Next" button, animate to next fieldset.
 */
jQuery(".button-wrapper .next").click(function () {
    if (animating) {
        return false;
    }
    animating = true;

    current_fs = jQuery(this).closest("fieldset");
    next_fs = jQuery(this).closest("fieldset").next("fieldset");

    // activate next step on progressbar using the index of next_fs
    jQuery("#progressbar li")
        .eq(jQuery("fieldset").index(next_fs))
        .addClass("active");

    // Scroll up to the progress bar.
    scroll_to_progress_bar_top();

    // show the next fieldset
    next_fs.show();

    // If there is no next_fs, means it's the last one, let's show the ripple animation.
    if (!next_fs.length) {
        setTimeout(function () {
            jQuery(".lds-ripple").show();
        }, 600);
    }

    // hide the current fieldset with style
    current_fs.animate(
        { opacity: 0 },
        {
            step: function (now, mx) {
                // as the opacity of current_fs reduces to 0 - stored in "now"
                // 1. scale current_fs down to 80%
                scale = 1 - (1 - now) * 0.2;
                // 2. bring next_fs from the right(50%)
                left = now * 50 + "%";
                // 3. increase opacity of next_fs to 1 as it moves in
                opacity = 1 - now;
                current_fs.css({
                    transform: "scale(" + scale + ")",
                    position: "absolute"
                });
                next_fs.css({ left: left, opacity: opacity });
            },
            duration: 800,
            complete: function () {
                current_fs.hide();
                current_fs.css({ position: "relative" });
                next_fs.css({ position: "relative" });
                animating = false;
            },
            // this comes from the custom easing plugin
            easing: "easeInOutBack"
        }
    );
});

/**
 * On clicking "Previous" button, animate back to previous fieldset.
 */
jQuery(".button-wrapper .previous").click(function () {
    if (animating) {
        return false;
    }
    animating = true;

    current_fs = jQuery(this).closest("fieldset");
    previous_fs = jQuery(this).closest("fieldset").prev();

    // de-activate current step on progressbar
    jQuery("#progressbar li")
        .eq(jQuery("fieldset").index(current_fs))
        .removeClass("active");

    // Scroll up to the progress bar.
    scroll_to_progress_bar_top();

    // show the previous fieldset
    previous_fs.show();
    previous_fs.css({ position: "absolute" });

    // hide the current fieldset with style
    current_fs.animate(
        { opacity: 0 },
        {
            step: function (now, mx) {
                // as the opacity of current_fs reduces to 0 - stored in "now"
                // 1. scale previous_fs from 80% to 100%
                scale = 0.8 + (1 - now) * 0.2;
                // 2. take current_fs to the right(50%) - from 0%
                left = (1 - now) * 50 + "%";
                // 3. increase opacity of previous_fs to 1 as it moves in
                opacity = 1 - now;
                current_fs.css({ left: left });
                previous_fs.css({ transform: "scale(" + scale + ")", opacity: opacity });
            },
            duration: 800,
            complete: function () {
                current_fs.hide();
                previous_fs
                    .removeAttr("style")
                    .css({ position: "relative", display: "block" });
                animating = false;
            },
            // this comes from the custom easing plugin
            easing: "easeInOutBack"
        }
    );
});

/**
 * Scroll to the top of the multi-step form. Needed for mobile.
 */
function scroll_to_progress_bar_top() {
    jQuery("html, body").animate(
        {
            scrollTop: jQuery("#msform").offset().top - 40
        },
        1200,
        "swing"
    );
}

