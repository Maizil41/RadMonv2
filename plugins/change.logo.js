/**
 * Radius Monitor Change Ticket Logo
 * Author : Maizil <https://github.com/maizil41>
 */
document.getElementById("changeLogo").addEventListener("submit",function(event){var messageElement=document.getElementById("message");if(messageElement){messageElement.style.display="none"}
if(this.checkValidity()){document.getElementById("loader").style.display="inline-block"}else{event.preventDefault()}})