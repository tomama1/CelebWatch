
function validatelogIn() {
		var emailValid = validateloginEmail();
		var pwValid = validateloginPw();
		if (emailValid && pwValid)
			return true;
		return false;
}
	
function validateloginEmail() {
	var email = document.forms["loginform"]["loginEmail"].value;
		if (email.length<1) {
			var errorrpt = document.getElementById("loginemailerror");
			errorrpt.innerHTML = "Please fill out your email.";
			document.getElementById("emaildiv").className="form-group has-error";
			return false;
			}
		return true;
		
}
	
function validateloginPw () {
	var pw = document.forms["loginform"]["loginPassword"].value;
		if (pw.length<1) {
			var errorrpt = document.getElementById("loginpwerror");
			errorrpt.innerHTML = "Please fill out your password.";
			document.getElementById("passdiv").className="form-group has-error";
			return false;
			}
		return true;
}
