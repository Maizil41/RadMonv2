/**
 * Radius Monitor Add PPP Profile
 * Made by Maizil <https://github.com/maizil41>
 */
document.addEventListener("DOMContentLoaded",function(){document.getElementById("addprofile").addEventListener("submit",function(event){var messageElement=document.getElementById("message");if(messageElement){messageElement.style.display="none"}
if(this.checkValidity()){document.getElementById("loader").style.display="inline-block"}else{event.preventDefault()}})});document.addEventListener("DOMContentLoaded",function(){fetch("../backend/bandwidth.php").then((response)=>response.json()).then((data)=>{let bwDropdown=document.getElementById("bw_id");if(Array.isArray(data.data)){data.data.forEach((item)=>{let option=document.createElement("option");option.value=item.bw_id;option.textContent=item.bw_name;bwDropdown.appendChild(option)});bwDropdown.addEventListener("change",function(){let selectedBw=bwDropdown.value;let selectedItem=data.data.find((item)=>item.bw_id===selectedBw);if(selectedItem){document.getElementById("rate_down").value=selectedItem.rate_down||"";document.getElementById("rate_up").value=selectedItem.rate_up||"";document.getElementById("bw_name").value=selectedItem.bw_name||""}})}else{console.error("Format tidak sesuai.")}}).catch((error)=>console.error("Error:",error));function calculateProfileBank(){let timeValue=parseFloat(document.getElementById("profileTimeBankInput").value);let timeUnit=document.getElementById("profileTimeBankSelect").value;let convertedValue;if(isNaN(timeValue)){console.log("Invalid input for profileTimeBankInput:",timeValue);return}
if(timeUnit==="M"){convertedValue=timeValue*60}else if(timeUnit==="H"){convertedValue=timeValue*3600}else if(timeUnit==="D"){convertedValue=timeValue*86400}else{console.log("Invalid time unit for profileTimeBankSelect:",timeUnit);return}
document.getElementById("profileTimeBank").value=convertedValue;console.log("profileTimeBank value set to:",convertedValue)}
document.getElementById("profileTimeBankInput").addEventListener("input",calculateProfileBank);document.getElementById("profileTimeBankSelect").addEventListener("change",calculateProfileBank)})