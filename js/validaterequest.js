function validate() {
		var celebnameValid = validatecelebName();
		var descriptionValid = validateDescription();
		if (celebnameValid && descriptionValid)
			return true;
		return false;
	}
	
	function validatecelebName() {
		var name = document.forms["newrequest"]["celebName"].value;
		if (name.length < 1) {
			var errorrpt = document.getElementById("celebnameerror");
			errorrpt.innerHTML = "Please enter the celebrity name.";
			document.getElementById("requestcelebname").className="form-group has-error";
			return false;
		}
		return true;
	}
	
	function validateDescription() {
		var dscrpt = document.forms["newrequest"]["description"].value;
		if (dscrpt.length < 1 || dscrpt == "Briefly describe this celebrity.") {
			var errorrpt = document.getElementById("descriptionerror");
			errorrpt.innerHTML = "Please enter the description.";
			document.getElementById("requestdescription").className="form-group has-error";
			return false;
		}
		return true;
	}
	