/**
 * Radius Monitor Add PPPoE
 * Author : Maizil <https://github.com/maizil41>
 */
document.addEventListener("DOMContentLoaded",function(){fetch("../backend/ppp.group.php").then((response)=>response.json()).then((data)=>{let planDropdown=document.getElementById("planDropup");data.plans.forEach((item)=>{let option=document.createElement("option");option.value=item.planName;option.textContent=item.planName;planDropdown.appendChild(option)})}).catch((error)=>console.error("Error:",error))});document.addEventListener("DOMContentLoaded",function(){fetch("../backend/ppp.ip.php").then((response)=>response.json()).then((data)=>{let pppoeIp=document.getElementById("ip_address");data.data.forEach((item)=>{let option=document.createElement("option");option.value=item;option.textContent=item;pppoeIp.appendChild(option)})}).catch((error)=>console.error("Error:",error))});document.getElementById("addUserForm").addEventListener("submit",function(event){var messageElement=document.getElementById("message");if(messageElement){messageElement.style.display="none"}
if(this.checkValidity()){document.getElementById("loader").style.display="inline-block"}else{event.preventDefault()}})
