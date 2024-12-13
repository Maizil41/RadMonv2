/**
 * Radius Monitor Add Profile
 * Author : Maizil <https://github.com/maizil41>
 */
document.addEventListener('DOMContentLoaded',function(){document.getElementById("addbwForm").addEventListener("submit",function(event){var messageElement=document.getElementById("message");if(messageElement){messageElement.style.display="none"}
if(this.checkValidity()){document.getElementById("loader").style.display="inline-block"}else{event.preventDefault()}});});