function handleRepsonse() {

}

function loadProfile() {
    const xhr = new XMLHttpRequest();
    xhr.addEventListener("load", handleResponse);
    xhr.open("POST", "api/get_profile.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(encodeURI(`email=${form.elements.login_email.value}&password=${form.elements.login_password.value}`));
}