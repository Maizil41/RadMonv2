/**
 * Radius Monitor Change Admin Pass
 * Author : Maizil <https://github.com/maizil41>
 */
function Pass(id){var x=document.getElementById(id);if(x.type==='password'){x.type='text'}else{x.type='password'}}
document.getElementById("changePass").addEventListener("submit",function(event){var messageElement=document.getElementById("message");if(messageElement){messageElement.style.display="none"}
if(this.checkValidity()){document.getElementById("loader").style.display="inline-block"}else{event.preventDefault()}})