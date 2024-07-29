const password=document.getElementById("password");
const password_repeat=document.getElementById("password_repeat");
const password_error=document.getElementById("password-err")
const submit_button=document.getElementById("submit");

addEventListenerMulti([password,password_repeat],"input",function(event) {
    if(password.value == password_repeat.value) {
        password_error.style.display="none";
        submit_button.disabled=false;
    } else {
        password_error.style.display="block";
        submit_button.disabled=true;
    }
});