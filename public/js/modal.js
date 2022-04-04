// Get the button that opens the modal
let btn = document.querySelectorAll("button.modal-button");

// All page modals
let modals = document.querySelectorAll('.modal');

// Get the <span> element that closes the modal
let spans = document.getElementsByClassName("close");

// When the user clicks the button, open the modal
for (let i = 0; i < btn.length; i++) {
    btn[i].onclick = function (e) {
        e.preventDefault();
        modal = document.querySelector(e.target.getAttribute("href"));
        modal.style.display = "block";
    }
}

// When the user clicks on <span> (x), close the modal
for (let i = 0; i < spans.length; i++) {
    spans[i].onclick = function () {
        for (let index in modals) {
            if (typeof modals[index].style !== 'undefined') modals[index].style.display = "none";
        }
    }
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
    if (event.target.classList.contains('modal')) {
        for (let index in modals) {
            if (typeof modals[index].style !== 'undefined') modals[index].style.display = "none";
        }
    }
}