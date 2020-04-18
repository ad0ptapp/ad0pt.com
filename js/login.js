const form = document.getElementById("form");
const email = document.getElementById("email");
const password = document.getElementById("password");

// Get Field Name
function getFieldName(input) {
  return input.id.charAt(0).toUpperCase() + input.id.slice(1);
}

// Submit Event Listener
form.addEventListener("submit", function (e) {
  e.preventDefault();
});
