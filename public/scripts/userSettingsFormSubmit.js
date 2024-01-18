var password = document.getElementById('password');
var confirmPassword = document.getElementById('confirm-password');
var submitButton = document.getElementById('submit-button');
var passwordWarning = document.getElementById('password-warning');

function enableOrDisableSubmitButton() {
    if (password.value === confirmPassword.value) {
        submitButton.disabled = false;
        passwordWarning.style.display = 'none';
    } else {
        submitButton.disabled = true;
        if (confirmPassword.value !== '') {
            passwordWarning.style.display = 'inline';
        } else {
            passwordWarning.style.display = 'none';
        }
    }
}

password.addEventListener('input', enableOrDisableSubmitButton);
confirmPassword.addEventListener('input', enableOrDisableSubmitButton);
enableOrDisableSubmitButton();