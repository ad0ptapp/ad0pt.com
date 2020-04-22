function handleLogin() {
	var resp = JSON.parse(this.response);
	var div = document.forms[0].children.message;
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
	var xhr = new XMLHttpRequest();
	xhr.addEventListener("load", handleLogin);
	xhr.open("POST", "api/login.php", true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send(encodeURI("email=" + form.elements.login_email.value + "&password=" + form.elements.login_password.value));
}
// Submit Event Listener
document.forms[0].addEventListener("submit", function (e) {
	doLogin(this);
  e.preventDefault();
});