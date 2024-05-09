// Get the offset position of the stickyBar
window.onload = function () { load() };

let mainTagTag
let stickyBar
let offsetTop
let defaultPaddingTop

function load() {
    stickyBar = document.getElementById('main_bar')
    offsetTop = stickyBar.offsetTop
    mainTag = document.getElementsByTagName('main')[0]
    defaultPaddingTop = mainTag.style.paddingTop
}

window.onscroll = function() { Scroll() };

function Scroll() {
    if (window.scrollY >= offsetTop) {
        stickyBar.classList.add('sticky')
        mainTag.style.paddingTop = stickyBar.offsetHeight + 'px'
        stickyBar.style.width = '99%'
    } else {
        stickyBar.classList.remove('sticky')
        mainTag.style.paddingTop = defaultPaddingTop
        stickyBar.style.width = '100%'
    }
}
