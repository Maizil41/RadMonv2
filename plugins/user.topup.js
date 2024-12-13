/**
 * Radius Monitor Topup Request
 * Author : Maizil <https://github.com/maizil41>
 */
function reject(id,username,whatsapp,amount){if(confirm(`Apakah Anda yakin ingin menolak transaksi ini?`)){$.ajax({url:"../backend/topup.php",type:"POST",data:{action:'reject',id:id,username:username,whatsapp_number:whatsapp,amount:amount},success:function(response){location.reload()},error:function(xhr,status,error){console.error("Terjadi kesalahan:",error);alert("Gagal menolak transaksi. Silakan coba lagi.")},})}}
function accept(id,username,whatsapp,amount){if(confirm(`Apakah Anda yakin ingin menerima transaksi ini?`)){$.ajax({url:"../backend/topup.php",type:"POST",data:{action:'accept',id:id,username:username,whatsapp_number:whatsapp,amount:amount},success:function(response){location.reload()},error:function(xhr,status,error){console.error("Terjadi kesalahan:",error);alert("Gagal menerima transaksi. Silakan coba lagi.")},})}}