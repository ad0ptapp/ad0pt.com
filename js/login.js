// Show input error message
function showError(input, message) {
	const formControl = input.parentElement;
	formControl.className = "form-control error";
	const small = formControl.querySelector("small");
	small.innerText = message;
}

// Show success outline
function showSuccess(input) {
	const formControl = input.parentElement;
	formControl.className = "form-control";
}

// Check email is valid
function checkEmail(input) {
	const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	if (re.test(input.value.trim())) {
		showSuccess(input);
		return true;
	} else {
		showError(input, "Email is not valid");
	}
}

function handleLogin() {
	const resp = JSON.parse(this.response);
	const div = document.forms[0].children.message;
	if(resp.message) {
		div.innerText = resp.message;
	}
	if(resp.success) {
		div.className = "message success";
		setTimeout(function(){ window.location.href = "index.php"; }, 1500);
	} else {
		div.className = "message error";
	}
}
function doLogin(form) {
	form.children.message.innerText = "";
	const xhr = new XMLHttpRequest();
	xhr.addEventListener("load", handleLogin);
	xhr.open("POST", "api/login.php", true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send(encodeURI(`email=${form.elements.login_email.value}&password=${form.elements.login_password.value}`));
}
// Submit Event Listener
document.forms[0].addEventListener("submit", function (e) {
	if(checkEmail(document.forms[0].elements["login_email"]))
		doLogin(this);
	e.preventDefault();
});