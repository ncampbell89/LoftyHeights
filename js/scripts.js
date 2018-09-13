// function that runs when burger btn is clicked
// function shows-hides the nav ul in vertical mode
const burgerBtn = document.getElementById('burger-btn')
const navUL = document.getElementById('navUL')
burgerBtn.addEventListener('click', toggleNavUL)

function toggleNavUL() {
    // show-hide the navUL on burger click
    if(navUL.style.display == "block") {
        navUL.style.display = "none";
    } else {
        navUL.style.display = "block";
    } // end if-else
} // function toggleNavUL()

// ##**##** FUNC RUNS ON MEDIA QUERY BREAK PT ##**##
var x = window.matchMedia("(min-width: 750px)")
// Attach listener function on state changes
x.addListener(onMediaQuery) 

function onMediaQuery(x) {
    if(!x.matches) { // If media query break point it hit
        navUL.style.display = "none";
    }
}


