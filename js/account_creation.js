const form = document.getElementById("form");
const email = document.getElementById("email");
const password = document.getElementById("password");
const password2 = document.getElementById("password2");
const minLength = 8;
const maxLength = 128;

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
  formControl.className = "form-control success";
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

// Check required fields
function checkRequired(inputArr) {
  let success = true;
  inputArr.forEach((input) => {
    if (input.value.trim() === "") {
      showError(input, "Passwords do not match");
      success = false;
    } else {
      showSuccess(input);
    }
  });
  return success;
}

// Check input length
function checkLength(input, min, max) {
  if (input.value.length < min) {
    showError(
      input,
      `${getFieldName(input)} must be at least ${min} characters`
    );
  } else if (input.value.length > max) {
    showError(
      input,
      `${getFieldName(input)} must be less than ${max} characters`
    );
  } else {
    showSuccess(input);
    return true;
  }
}

// Check that passwords match
function checkPasswordMatch(input1, input2) {
  if (input1.value !== input2.value) {
    showError(input2, "Passwords do not match");
  } else {
    return true;
  }
}

// Get Field Name
function getFieldName(input) {
  return input.id.charAt(0).toUpperCase() + input.id.slice(1);
}

// Submit Event Listener
form.addEventListener("submit", function (e) {
  let count = 0;
  if(checkRequired([password, password2]))
    count++;
  if(checkPasswordMatch(password, password2))
    count++;
  if(checkLength(password, minLength, maxLength))
    count++;
  if(checkEmail(email))
    count++;

  if(count < 4) {
    e.preventDefault();
  } else {
    document.forms['form'].submit();
  }
});
