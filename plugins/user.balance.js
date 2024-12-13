/**
 * Radius Monitor Client List
 * Author : Maizil <https://github.com/maizil41>
 */
 function confirmDelete(id){if(confirm(`Apakah Anda yakin ingin menghapus pelanggan ini?`)){$.ajax({url:"../backend/delclient.php",type:"POST",data:{action:'delete',id:id,},success:function(response){location.reload()},error:function(xhr,status,error){console.error("Terjadi kesalahan:",error);alert("Gagal menghapus transaksi. Silakan coba lagi.")},})}}