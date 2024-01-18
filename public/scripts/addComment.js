var floatingWindow = document.getElementById("floating-window");

function openForm() {
    floatingWindow.style.display = "block";
}

function closeForm(event) {
    event.preventDefault();
    floatingWindow.style.display = "none";
}

document.querySelector('.comment-form').addEventListener('submit', function(event) {
    var content = CKEDITOR.instances.content.getData();
    if(content.trim() === '') {
        alert('Content cannot be empty');
        event.preventDefault(); // prevent form submission
    }
});