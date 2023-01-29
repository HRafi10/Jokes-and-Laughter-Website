

function validateName(name) {
	let nameRegEx = /^[a-zA-Z]+$/;
    let n = name.value;
	if (nameRegEx.test(n))
		return true;
	else
		return false;
}

function validatePassword(pass) { 
	let pw = pass.value;  
    let psRegEx =/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]+$/;
	//check empty password field  
	if(pw == "") {  
		console.log("Password must be filled out!");
		return false;  
	}  
	 
   //minimum password length validation  
	if(pw.length < 8) {  
		console.log("Password must be 8 to 16 character long!");
		return false;  
	}  
	
  //maximum length of password validation  
	if(pw.length > 16) {  
		console.log("Password must be 8 to 16 character long!");
		return false;  
	} 
    if(!psRegEx.test(pw))
    {  
        console.log("Password must include at least one number character!");
       return false;
        
    }
    else {  
	   console.log("Password is correct"); 
	   return true; 
	}  
  }  

  //date of birth function
  function validateDateOfBirth(date) {  
	var dob = date.value;  
	//check empty field  
	if(dob == "") {  
		console.log("date of Birth must be filled out!");
		return false;  
	}  
	 let dobRegex= /^\d{4}[-]\d{2}[-]\d{2}$/;
    // cheking correct form
	if(!dobRegex.test(dob)) {  
		console.log("date of birth not in correct form!");
		return false;  
	} else {  
	   console.log("date of birth in correct form");
	   return true;  
	}  
  }

  //username function
  function validateUsername(user) {
	//Get text field
	let uname = user.value;
 
	//Check if field was actually retrieved
	if (uname == null) {
		  console.log("FIXME: Programmer error - field fname does not exist!");
		  return false;
	}
 
	//Get username value and remove leading and trailing whitespaces
	let unameVal = uname.trim();
 
	//Check if field value is empty
	if (unameVal == "") {
		  console.log("username must be filled out");
		  return false;
	}
 
	//Check if field value is too long
	if (unameVal.length > 30) {
		  console.log(" username must be 30 characters or less.");
		  return false;
	}
 
	//Check if field value looks like a name
	let unameRegex = /^[a-zA-Z0-9_]+$/;
	if (!unameRegex.test(unameVal)) {
		  console.log("username not in correct form.");
		  return false;
	}
 
	console.log(`username: ${unameVal}`);
	return true;
 } 

 // function for avater

  function validateAvater(ava) {  
	var avater = ava.value;  
	//check empty field  
	if(avater == "") {  
		console.log("avater/image must be filled out!");
		return false;  
	}  
	 let avaRegex= /^[^\n]+\.[a-zA-Z]{3,4}$/;
    // cheking correct form
	if(!avaRegex.test(avater)) {  
		console.log("avater/image not in correct form!");
		return false;  
	} else {  
	   console.log("avater in correct form"); 
	   return true; 
	}  
  }

function validateLogin(event) {

	let uname = document.getElementById("username");

	let pword = document.getElementById("password");

	let formIsValid = true;

	if (!validateUsername(uname)) {

		console.log("'" + uname.value + "' is not a valid username");
		formIsValid = false;
	}

    if (!validatePassword(pword)) {

		console.log("'" + pword.value + "' is not a valid password and must include one non-letter char");
		formIsValid = false;
	}

	if (formIsValid === false) {

		event.preventDefault();
	
	}
	else {
		console.log("validation successful, sending data to the server");
	}
}

function fNameHandler(event) {
	let fname = event.target;
	console.log("Validating first name: " + fname.value);
	return validateName(fname);

}
function lNameHandler(event) {
	let lname = event.target;
	console.log("Validating last name: " + lname.value);
	return validateName(lname);
	
}

function pwdHandler(event) {
	let pwd = event.target;
	console.log("Validating password: " + pwd.value);
	return validatePassword(pwd);

}

function cpwdHandler(event) {
	let pwd = document.getElementById("password").value;
	let cpwd = document.getElementById("cpassword").value;
	if(cpwd != pwd)
	{
	   console.log("password doesnt match");
	   return false;
	}

	else
	{
	   return true;
	}

}

function avatarHandler(event) {
	let avatar = event.target;
	console.log("Validating avater: " + avatar.value);
	return validateAvater(avatar);

}

function usernameHandler(event) {
	let unm = event.target;
	console.log("Validating  username: " + unm.value);
	return validateUsername(unm);
	
}

function dobHandler(event){
	let dob = event.target;
	console.log("Validating date of birth: " + dob.value);
	return validateDateOfBirth(dob);

}
function validateSignup(event)
{

	let uname = document.getElementById("username");
	let fname = document.getElementById("fname");
	let lname = document.getElementById("lname");
	let pword = document.getElementById("password");
    let cpaas= document.getElementById("confirm-password");
	let dob = document.getElementById("date-of-birth");
	let profilephoto =document.getElementById("profile-photo");

	let formIsValid = true;

	if (!validateUsername(uname)) {

		console.log("'" + uname.value + "' is not a valid username");
		formIsValid = false;
	}
	if (!validateName(fname)) {

		console.log("'" + fname.value + "' is not a valid firstname");
		formIsValid = false;
	}
	if (!validateName(lname)) {

		console.log("'" + lname.value + "' is not a valid lastname");
		formIsValid = false;
	}


	
    if (!validatePassword(pword)) {

		console.log("'" + pword.value + "' is not a valid password");
		formIsValid = false;
	}

    if(pword.value != cpaas.value)
    {
        console.log("password and confirm-password doesn't match ");
		formIsValid = false;

    }

	if (!validateDateOfBirth(dob)) {

		console.log("'" + dob.value + "' is not a valid date of Birth");
		formIsValid = false;
	}
	if (!validateAvater(profilephoto)) {

		console.log("'" + profilephoto.value + "' is not a valid avater");
		formIsValid = false;
	}

	if (!formIsValid) {
		event.preventDefault();
	
	}
	else {
		console.log("validation successful, sending data to the server");
	}

}

//functions for postjoke page

function validateJokeTitle(jname) {
	//Get text field
	let j = jname.value;
 
	//Check if field was actually retrieved
	if (j == null) {
		  console.log("FIXME: Programmer error - field fname does not exist!");
		  return false;
	}
 
	let jVal = j.trim();
 
	//Check if field value is empty
	if (jVal == "") {
		  console.log("Joke title must be filled out");
		  return false;
	}
 
	//Check if field value is too long
	if (jVal.length > 50) {
		  console.log(" Joke title must be 50 characters or less.");
		  return false;
	}
    
	else{

		 console.log("Joke title correct");
	      return true;
	}
	
 } 

 function validateJoke(joke) {
	//Get text field
	let jk = joke.value;
 
	//Check if field was actually retrieved
	if (jk == null) {
		  console.log("FIXME: Programmer error - field fname does not exist!");
		  return false;
	}
 
	let jkVal = jk.trim();
 
	//Check if field value is empty
	if (jkVal == "") {
		  console.log("Joke area must be filled out");
		  return false;
	}
 
	else{

		 console.log("Joke area is perfect");
	      return true;
	}
	
 } 

 function jkTitleHandler(event){

	let jTitle = event.target;
	console.log("Validating Joke Title: " + jTitle.value);
	return validateJokeTitle(jTitle);

 }

 function jkHandler(event){

	let jk = event.target;
	console.log("Validating Joke area: " + jk.value);
	return validateJoke(jk);

}
// function for dynamic char count
function getCount(event){
    
	let max=50;
	let charCount= event.target.value.length;

	let charCountOut=document.getElementById("char-count");
    if(charCount <= max){
	   charCountOut.innerHTML= "You wrote " + charCount +" characters & left " + (max-charCount) +" characters";
	}
	else{
	   charCountOut.innerHTML= "You wrote " + charCount +" characters & left 0 characters";
	}
}

function validateSubmitJoke(event) {

	let jt = document.getElementById("jokename");

	let joke = document.getElementById("fulljoke");

	let formIsValid = true;

	if (!validateJokeTitle(jt)) {

		console.log("'" + jt.value + "' is not a valid Joke title");
		formIsValid = false;
	}

    if (!validateJoke(joke)) {

		console.log("'" + joke.value + "' Joke area is not fiiled in");
		formIsValid = false;
	}

	if (formIsValid === false) {

		event.preventDefault();
	
	}

	else {
		console.log("validation successful, sending data to the server");
	}
}

// jokedetail page code

//this fucntion sets the value of input to 0 and hides the decrease button
function setRating() {
    var x = 0;
    document.getElementById("rating").value = parseInt(x);
    document.getElementById("decrease").hidden = true;

  }
    
	  function increaseValue() {
		var value = parseInt(document.getElementById("rating").value, 10);
		value = isNaN(value) ? 0 : value;
		if(value <5){
		   value++;
		   document.getElementById("rating").value = value;
		}
		if(value > 4){
		   document.getElementById("increase").hidden = true;	
		   document.getElementById("rating").value = value;
	    }
	  }
	  
	  function decreaseValue() {
		var value = parseInt(document.getElementById("rating").value, 10);
		value = isNaN(value) ? 0 : value;
		value < 1 ? value = 1 : '';
		if(value <= 5)
		{
			document.getElementById("increase").hidden = false;

		}
		value--;
		document.getElementById("rating").value = value;
	  }
  

	  function showRating(event) {

		// TODO 4b: Get the username from the event target
		let rating = document.getElementById("rating");
	
		if (rating > 0 && rating < 6) {
			let xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function () {
				if (xhr.readyState == 4 && xhr.status == 200) {
	
					let rat_arr = JSON.parse(this.responseText);
					// TODO 6a: Parse the response text into JSON format and keep it on the 'loginHistoryArray' variable;
	
					let latest_rating = document.getElementById("latest-rating");
					latest_rating.innerHTML = '';
					if (rat_ar.length > 0) {
						let rat = rat_arr[0].rating;
						let pTag = document.createElement("p");
						pTag.textContent = " You rated ";
						latest_rating.append(pTag);
	
						if (rating == rat) {
	
							// TODO 6b: Complete the logic in the for loop to iterate all items of the 'loginHistoryArray' array.
							
	
							let jsonObject = rat_ar[0];
							let your_rat = jsonObject.rating;
	
	
							// TODO 6c: create p tag for each loginTime and append that tag as a child of the lastLoginDiv.  
							let pTag = document.createElement("p");
							pTag.textContent = your_rat;
							latest_rating.append(pTag);
		
	
	
							// TODO 6b: Loop Ends
							
						}
					} else {
						const pTag = document.createElement("p");
						const textnode = document.createTextNode("You didn't rate this joke");
						pTag.appendChild(textnode);
						lastLoginDiv.appendChild(pTag);
					}
				}
			}
	
			// TODO 4c: Open and send a GET ajax request including the username to the 'ajax_backend.php' file. 
			// ...
			xhr.open("GET", "ajax_backend.php?q=" + rating, true);
			xhr.send();
		} else {
			let lastLoginText = document.getElementById("last-login");
			lastLoginText.innerHTML = "";
		}
	}