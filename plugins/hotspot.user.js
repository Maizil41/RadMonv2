/**
 * Radius Monitor Hotspot User
 * Author : Maizil <https://github.com/maizil41>
 */
function printTicket(username,planName){var selectElement=document.getElementById('selectPrinter'+username);var selectedPrinter=selectElement.value;var url='../voucher/'+selectedPrinter+'?type=batch&plan='+encodeURIComponent(planName)+'&accounts=Username,Password||'+encodeURIComponent(username)+',Accept';var newWindow=window.open(url,'_blank','width=800,height=600,scrollbars=yes');newWindow.onload=function(){newWindow.print()}}
document.getElementById('deleteSelected').addEventListener('click',function(){const checkboxes=document.querySelectorAll('.delete-checkbox:checked');const selectedUsers=Array.from(checkboxes).map(checkbox=>checkbox.value);if(selectedUsers.length===0){alert('Tidak ada voucher yang dipilih.');return}
if(confirm('Apakah Anda yakin ingin menghapus voucher yang dipilih?')){fetch('../backend/delete_selected.php',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({users:selectedUsers})}).then(response=>response.json()).then(data=>{if(data.success){location.reload()}else{alert('Gagal menghapus pengguna.')}}).catch(error=>console.error('Error:',error))}});
document.getElementById('checkAll').addEventListener('change',function(){const checkboxes=document.querySelectorAll('.delete-checkbox');const isChecked=this.checked;checkboxes.forEach(checkbox=>{checkbox.checked=isChecked})});
