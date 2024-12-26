/**
 * Radius Monitor Upload Logo
 * Author : Maizil <https://github.com/maizil41>
 */
async function loadFileList(){const response=await fetch("../backend/logo.php?action=list");const data=await response.json();const table=document.getElementById("fileTable");table.innerHTML="";if(data.status==="success"&&data.files&&Array.isArray(data.files)){data.files.forEach((file)=>{const row=document.createElement("tr");const timestamp=new Date().getTime();row.innerHTML=`
                <td>
                    <a href="../img/logo/${file.name}?t=${timestamp}" target="_blank">
                        <img height="80px" src="../img/logo/${file.name}?t=${timestamp}" alt="${file.name}">
                    </a><br>
                </td>
                <td style="text-align: center;">${file.size}</td>
                <td style="text-align: center;">
                    <button class="btn bg-danger" onclick="deleteFile('${file.name}')"><i class="fa fa-trash"></i></button>
                    <a class="btn bg-success" href="../backend/logo.php?action=download&file=${encodeURIComponent(file.name)}"><i class="fa fa-download"></i></a>
                </td>
            `;table.appendChild(row)})}else{table.innerHTML='<tr><td colspan="3" style="text-align: center;">Tidak ada data</td></tr>'}}
document.getElementById("uploadButton").addEventListener("click",async()=>{const formData=new FormData();const fileInput=document.getElementById("UploadLogo");if(fileInput.files.length===0){alert("Please select a file to upload");return}
formData.append("UploadLogo",fileInput.files[0]);const response=await fetch("../backend/logo.php",{method:"POST",body:formData});const data=await response.json();document.getElementById("message").innerText=data.message;if(data.status==="success"){fileInput.value=""}
loadFileList()});async function deleteFile(fileName){if(confirm("Yakin ingin menghapus logo ini?")){const response=await fetch(`../backend/logo.php?action=delete&file=${encodeURIComponent(fileName)}`);const data=await response.json();document.getElementById("message").innerText=data.message;loadFileList()}}
document.addEventListener("DOMContentLoaded",loadFileList)

