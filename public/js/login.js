document.getElementById("formButton").addEventListener("click", formSubmission);

function formSubmission(){
  var email = document.getElementById("email").value;
  var password = document.getElementById("password").value;

  var formValid = formValidation(email, password);
  console.log(formValid)
}

function formValidation(email, password){
  var valid = true;

  if(email === ""){
      valid = false;
      document.getElementById("emailError").innerText = "Email cannot be empty";
  }

  if(password === ""){
      valid = false;
      document.getElementById("passwordError").innerText = "Password cannot be empty";
  }

  if(valid == true){
      document.getElementById("emailError").innerText = "";
      document.getElementById("passwordError").innerText = "";
  }
  return valid;
}