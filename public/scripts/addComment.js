var floatingWindow = document.getElementById("floating-window");
var isDragging = false;
var previousX, previousY;

floatingWindow.addEventListener('mousedown', function(e) {
    isDragging = true;
    previousX = e.clientX;
    previousY = e.clientY;
});

document.addEventListener('mousemove', function(e) {
    if (!isDragging) return;
    var deltaX = e.clientX - previousX;
    var deltaY = e.clientY - previousY;
    var style = window.getComputedStyle(floatingWindow);
    var left = parseInt(style.left) || 0;
    var top = parseInt(style.top) || 0;
    floatingWindow.style.left = (left + deltaX) + "px";
    floatingWindow.style.top = (top + deltaY) + "px";
    previousX = e.clientX;
    previousY = e.clientY;
});

document.addEventListener('mouseup', function() {
    isDragging = false;
});

function openForm() {
    floatingWindow.style.display = "block";
}

function closeForm(event) {
    event.preventDefault();
    floatingWindow.style.display = "none";
}

function validateForm() {
    var content = document.getElementById("content").value;
    var submitButton = document.getElementById("submit-button");

    if (content.trim() === "") {
        submitButton.disabled = true;
        submitButton.style.backgroundColor = "gray";
    } else {
        submitButton.disabled = false;
        submitButton.style.backgroundColor = "";
    }
}

window.onload = validateForm;