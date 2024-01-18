var floatingWindow = document.getElementById("floating-window");

function openForm() {
    floatingWindow.style.display = "flex";
}

function closeForm(event) {
    event.preventDefault();
    floatingWindow.style.display = "none";
}
document.querySelector('.post-form').addEventListener('submit', function(event) {
    var title = document.getElementById('title').value;
    var content = CKEDITOR.instances.content.getData();

    if(title.trim() === '') {
        alert('Title cannot be empty');
        event.preventDefault(); // prevent form submission
    } else if(content.trim() === '') {
        alert('Content cannot be empty');
        event.preventDefault(); // prevent form submission
    }
});