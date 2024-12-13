/**
 * Radius Monitor Add MAC
 * Author : Maizil <https://github.com/maizil41>
 */
 function toggleMacInput(){const selectMacRow=document.getElementById('SelectMac');const inputMacRow=document.getElementById('InputMac');const macDropdown=document.getElementById('macDropdown');const macManualInput=document.querySelector('input[name="macManual"]');if(document.getElementById('Select').checked){selectMacRow.style.display='';inputMacRow.style.display='none';macManualInput.value=''}else{selectMacRow.style.display='none';inputMacRow.style.display='';macDropdown.value=''}}
fetch('../backend/macauth.php').then(response=>response.json()).then(data=>{const macDropdown=document.getElementById('macDropdown');data.data.forEach(item=>{const option=document.createElement('option');option.value=item.mac_address;option.textContent=item.mac_address;macDropdown.appendChild(option)})}).catch(error=>console.error('Error fetching MAC addresses:',error));document.addEventListener("DOMContentLoaded",()=>{fetch("../backend/radgroup.php").then(response=>response.json()).then(data=>{const planDropdown=document.getElementById("planDropup");data.plans.forEach(item=>{const option=document.createElement("option");option.value=item.planName;option.textContent=item.planName;planDropdown.appendChild(option)})}).catch(error=>console.error("Error fetching plans:",error))});document.addEventListener("DOMContentLoaded",()=>{document.getElementById("addMacForm").addEventListener("submit",function(event){const isSelectChecked=document.getElementById("Select").checked;const isManualChecked=document.getElementById("Manual").checked;const macDropdown=document.getElementById("macDropdown");const macManualInput=document.querySelector('input[name="macManual"]');const messageElement=document.getElementById("message");const loader=document.getElementById("loader");if(messageElement){messageElement.style.display="none"}
if(isSelectChecked&&macDropdown.value===""){alert("Select a MAC Address.");event.preventDefault()}else if(isManualChecked&&macManualInput.value.trim()===""){alert("Enter a MAC Address.");event.preventDefault()}else{if(this.checkValidity()){loader.style.display="inline-block"}else{event.preventDefault()}}})})