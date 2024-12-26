/**
 * Radius Monitor Backup & Restore
 * Author : Maizil <https://github.com/maizil41>
 */
async function loadFileList(){const response=await fetch('../backend/backup.php?action=list');const data=await response.json();const table=document.getElementById('fileTable');table.innerHTML='';if(data.status==='success'&&data.files){data.files.forEach((file,index)=>{const row=document.createElement('tr');row.innerHTML=`
                    <td style="text-align: center;">${index + 1}</td>
                    <td style="text-align: center;"><i class="fa fa-database"></i> ${file.name}</td>
                    <td style="text-align: center;">${file.size}</td>
                    <td style="text-align: center;">
                        <button class="btn bg-danger" onclick="deleteFile('${file.name}')"><i class="fa fa-trash"></i></button>
                        <button class="btn bg-warning" onclick="restoreFile('${file.name}')"><i class="fa fa-rotate-left"></i></button>
                        <a class="btn bg-success" href="../backend/backup.php?action=download&file=${encodeURIComponent(file.name)}"><i class="fa fa-download"></i></a>
                    </td>
                `;table.appendChild(row)})}else{table.innerHTML='<tr><td colspan="4" style="text-align: center;">Tidak ada data</td></tr>'}}
document.getElementById('uploadButton').addEventListener('click',async()=>{const formData=new FormData();const fileInput=document.getElementById('UploadDB');if(fileInput.files.length===0){alert('Please select a file to upload');return}
formData.append('UploadDB',fileInput.files[0]);const response=await fetch('../backend/backup.php',{method:'POST',body:formData});const data=await response.json();document.getElementById('message').innerText=data.message;loadFileList()});document.getElementById('backupButton').addEventListener('click',async()=>{const response=await fetch('../backend/backup.php?action=backup');const data=await response.json();document.getElementById('message').innerText=data.message;loadFileList()});async function deleteFile(fileName){if(confirm('Yakin ingin menghapus database ini?')){const response=await fetch(`../backend/backup.php?action=delete&file=${encodeURIComponent(fileName)}`);const data=await response.json();document.getElementById('message').innerText=data.message;loadFileList()}}
async function restoreFile(fileName){if(confirm('Yakin ingin merestore database ini?')){const response=await fetch(`../backend/backup.php?action=restore&file=${encodeURIComponent(fileName)}`);const data=await response.json();document.getElementById('message').innerText=data.message}}
document.addEventListener('DOMContentLoaded',loadFileList)
