/**
 * Radius Monitor Delete Bandwidth
 * Author : Maizil <https://github.com/maizil41>
 */
function deleteBw(bw_name,bw_id){if(confirm("Apakah anda yakin ingin menghapus bandwidth "+bw_name+"?")){$.ajax({url:"../backend/delete_bw.php",type:"GET",data:{id:bw_id},success:function(response){location.reload()},error:function(xhr,status,error){console.error("Terjadi kesalahan:",error)},})}}