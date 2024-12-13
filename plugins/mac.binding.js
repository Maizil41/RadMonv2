/**
 * Radius Monitor Mac Binding
 * Author : Maizil <https://github.com/maizil41>
 */
$(document).ready(function(){makeAllSortable();$("#filterTable").on("keyup",function(){var value=$(this).val().toLowerCase();$("#dataTable tbody tr").filter(function(){$(this).toggle($(this).text().toLowerCase().indexOf(value)>-1)})})});
const planName = new URLSearchParams(window.location.search).get('planName') || '';
document.getElementById('userstatus').addEventListener('change',function(){const status=this.value;window.location.href=`?planName=${planName}&status=${status}`});
function deleteUser(username){if(confirm("Apakah anda yakin ingin menghapus user "+username+"?")){$.ajax({url:"../backend/delete.php",type:"GET",data:{id:username},success:function(response){location.reload()},error:function(xhr,status,error){console.error("Terjadi kesalahan:",error)},})}}
function resetuser(username){if(confirm("Apakah anda yakin ingin mereset user "+username+"?")){$.ajax({url:"../backend/reset.php",type:"GET",data:{id:username},success:function(response){location.reload()},error:function(xhr,status,error){console.error("Terjadi kesalahan:",error)},})}}
