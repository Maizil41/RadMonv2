/**
 * Radius Monitor PPPoE User
 * Author : Maizil <https://github.com/maizil41>
 */
document.getElementById("deleteSelected").addEventListener("click",function(){const checkboxes=document.querySelectorAll(".delete-checkbox:checked");const selectedUsers=Array.from(checkboxes).map((checkbox)=>checkbox.value);if(selectedUsers.length===0){alert("Tidak ada pppoe yang dipilih.");return}
if(confirm("Apakah Anda yakin ingin menghapus pppoe yang dipilih?")){fetch("../backend/delete_selected.php",{method:"POST",headers:{"Content-Type":"application/json"},body:JSON.stringify({users:selectedUsers})}).then((response)=>response.json()).then((data)=>{if(data.success){location.reload()}else{alert("Gagal menghapus pengguna.")}}).catch((error)=>console.error("Error:",error))}});document.getElementById("checkAll").addEventListener("change",function(){const checkboxes=document.querySelectorAll(".delete-checkbox");const isChecked=this.checked;checkboxes.forEach((checkbox)=>{checkbox.checked=isChecked})})