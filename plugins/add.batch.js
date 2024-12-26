/**
 * Radius Monitor Add Batch
 * Author : Maizil <https://github.com/maizil41>
 */
document.addEventListener("DOMContentLoaded",function(){function generateRandomString(length){const chars="ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";let result="";for(let i=0;i<length;i++){const randomIndex=Math.floor(Math.random()*chars.length);result+=chars[randomIndex]}
return result}
const randomBatchName=generateRandomString(4);const form=document.querySelector("form");const hiddenInput=document.createElement("input");hiddenInput.type="hidden";hiddenInput.name="batchName";hiddenInput.value=randomBatchName;form.appendChild(hiddenInput)});document.getElementById("addUserForm").addEventListener("submit",function(event){var messageElement=document.getElementById("message");if(messageElement){messageElement.style.display="none"}
if(this.checkValidity()){document.getElementById("loader").style.display="inline-block"}else{event.preventDefault()}})

