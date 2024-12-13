/**
 * Radius Monitor Delete User
 * Author : Maizil <https://github.com/maizil41>
 */
function deleteUser(username){if(confirm("Apakah anda yakin ingin menghapus user "+username+"?")){$.ajax({url:"../backend/delete.ppp.php",type:"GET",data:{id:username},success:function(response){location.reload()},error:function(xhr,status,error){console.error("Terjadi kesalahan:",error)},})}}
function resetuser(username){if(confirm("Apakah anda yakin ingin mereset user "+username+"?")){$.ajax({url:"../backend/reset.php",type:"GET",data:{id:username},success:function(response){location.reload()},error:function(xhr,status,error){console.error("Terjadi kesalahan:",error)},})}}
$(document).ready(function(){makeAllSortable();$("#filterTable").on("keyup",function(){var value=$(this).val().toLowerCase();$("#dataTable tbody tr").filter(function(){$(this).toggle($(this).text().toLowerCase().indexOf(value)>-1)})})});
