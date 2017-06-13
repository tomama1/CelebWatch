	function validate() {
		var celebnameValid = validatecelebName();
		var occupValid = validateoccupation();
		var birthValid = validatebirthday();
		var wikiValid = validatewiki();
		var wikiIDValid = validatewikiID();
		var twitterValid = validatetwitter();
		var twitterIDValid = validatetwitterID();
		var instaValid = validateinsta();
		if (celebnameValid && occupValid && birthValid && wikiValid && wikiIDValid && twitterValid && twitterIDValid && instaValid)
			return true;
		return false;
	}
	
	function validatecelebName() {
		var name = document.forms["newceleb"]["celebName"].value;
		if (name.length < 1) {
			var errorrpt = document.getElementById("celebnameerror");
			errorrpt.innerHTML = "Please enter the celebrity name.";
			document.getElementById("celebname").className="form-group has-error";
			return false;
		}
		return true;
	}
	
	function validateoccupation() {
		var occupations = document.forms["newceleb"].occupations;
		var length = occupations.length;
		var errorrpt = document.getElementById("occuperror");
		for (var i=0;i<length;i++){
			if (occupations[i].checked){
				return true;
			}
		}
		errorrpt.innerHTML = "Please enter the occupation.";
		document.getElementById("occupation").className="form-group has-error";
		return false;
	}
	
	function validatebirthday() {
		var birthday = document.forms["newceleb"]["birthday"].value;
		if (birthday.length < 1) {
			var errorrpt = document.getElementById("birtherror");
			errorrpt.innerHTML = "Please enter the birthday.";
			document.getElementById("birthdaydiv").className="form-group has-error";
			return false;
		}
		return true;
	}
	
	function validatewiki() {
		var wiki = document.forms["newceleb"]["wiki"].value;
		if (wiki.length < 1) {
			var errorrpt = document.getElementById("wikierror");
			errorrpt.innerHTML = "Please enter the Wikipedia page.";
			document.getElementById("wikidiv").className="form-group has-error";
			return false;
		}
		return true;
	}

	function validatewikiID(){
		var twitter = document.forms["newceleb"]["wikiID"].value;
		if (twitter.length < 1) {
			var errorrpt = document.getElementById("wikiIDerror");
			errorrpt.innerHTML = "Please enter the Wiki ID.";
			document.getElementById("wikiIDdiv").className="form-group has-error";
			return false;
		}
		return true;
	}
	
	function validatetwitter() {
		var twitter = document.forms["newceleb"]["twitter"].value;
		if (twitter.length < 1) {
			var errorrpt = document.getElementById("twittererror");
			errorrpt.innerHTML = "Please enter the Twitter page.";
			document.getElementById("twitterdiv").className="form-group has-error";
			return false;
		}
		return true;
	}
	
	function validatetwitterID() {
		var twitter = document.forms["newceleb"]["twitterID"].value;
		if (twitter.length < 1) {
			var errorrpt = document.getElementById("twitterIDerror");
			errorrpt.innerHTML = "Please enter the Twitter ID.";
			document.getElementById("twitterIDdiv").className="form-group has-error";
			return false;
		}
		return true;
	}
	
	function validateinsta() {
		var insta = document.forms["newceleb"]["insta"].value;
		if (insta.length < 1) {
			var errorrpt = document.getElementById("instaerror");
			errorrpt.innerHTML = "Please enter the Instagram page.";
			document.getElementById("instadiv").className="form-group has-error";
			return false;
		}
		return true;
	}

