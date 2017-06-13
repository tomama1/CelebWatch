	function validate() {
		var nameValid = validateName();
		var emailValid = validateEmail();
		var pwValid = validatePw();
		var pwchkValid = validatePwchk();
		var termsValid = validateTerms();
		if (nameValid && emailValid && pwValid && pwchkValid && termsValid)
			//header("Location: http://")
			return true;
		return false;
	}
	
	
	function validateName() {
		var name = document.forms["signup"]["name"].value;
		if (name.length < 1) {
			var errorrpt = document.getElementById("nameerror");
			errorrpt.innerHTML = "Please enter your name";
			document.getElementById("signupname").className="form-group has-error";
			return false;
		}
		return true;
	}
	
	function validateEmail() {
		var email = document.forms["signup"]["email"].value;
		var emailRegex = /^\S+@\S+\.\S+$/;
		if (email.length < 1) {
			var errorrpt = document.getElementById("emailerror");
			errorrpt.innerHTML = "Please enter your email";
			document.getElementById("signupemail").className="form-group has-error";
			return false;
		}		
		if (!emailRegex.test(email))
		{
			var errorrpt = document.getElementById("emailerror");
			errorrpt.innerHTML = "Please enter a valid email";
			document.getElementById("signupemail").className="form-group has-error";
			return false;
		}
		return true;
		
	}
	
	function validatePw() {
		var pw = document.forms["signup"]["password"].value;
		if (pw.length < 1) {
			var errorrpt = document.getElementById("pwerror");
			errorrpt.innerHTML = "Please enter your password.";
			document.getElementById("signuppass").className="form-group has-error";
			return false;
		}
		return true;
	}

	function validatePwchk() {
		var pwchk = document.forms["signup"]["verifyp"].value;
		if (pwchk.length < 1) {
			var errorrpt = document.getElementById("pwchkerror");
			errorrpt.innerHTML = "Please verify password.";
			document.getElementById("checkpass").className="form-group has-error";
			return false;
		}
		return true;
	}
	
		
	function validateTerms() {
		var terms = document.getElementById("terms").checked;
		if (terms == false) {
			var errorrpt = document.getElementById("termerror");
			errorrpt.innerHTML = "Please agree to the Terms and Conditions";
			document.getElementById("termscond").className="checkbox has-error";
			return false;
		}
		return true;
	}