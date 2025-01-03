/**
 * Radius Monitor Add Client
 * Author : Maizil <https://github.com/maizil41>
 */
document.getElementById("addUserForm").addEventListener("submit",function(event){var messageElement=document.getElementById("message");if(messageElement){messageElement.style.display="none"}
if(this.checkValidity()){document.getElementById("loader").style.display="inline-block"}else{event.preventDefault()}})
