/**
 * Radius Monitor Delete User
 * Author : Maizil <https://github.com/maizil41>
 */
$(document).ready(function(){makeAllSortable();$("#filterTable").on("keyup",function(){var value=$(this).val().toLowerCase();$("#dataTable tbody tr").filter(function(){$(this).toggle($(this).text().toLowerCase().indexOf(value)>-1)})})});const API_URL="../backend/ppp.profile.php";async function fetchData(){try{const response=await fetch(API_URL);const result=await response.json();if(result.status==="success"){document.getElementById("totalBatches").innerText=result.total_batches;if(result.data.length>0){const tableBody=document.querySelector("#tFilter tbody");tableBody.innerHTML="";result.data.forEach((item)=>{const iconClass=item.planCost==="Rp 0"||item.planCost==="0"?"text-warning":"text-green";const row=`
<tr>
<td class="text-center">
<i class='fa fa-trash text-danger pointer' onclick="deletePlan('${item.planName}')"></i>&nbsp;&nbsp;&nbsp;&nbsp;
<i class='fa fa-edit pointer' onclick="editPlan('${item.id}')"></i> 
</td>
<td class="text-center">
<i class='fa fa-ci fa-circle ${iconClass}'></i> ${item.planName}
</td>
<td class="text-center">${item.planCost}</td>
<td class="text-center">${item.maxAllSession}</td>
<td class="text-center">${item.bandwidthName}</td>
</tr>
`;tableBody.innerHTML+=row})}else{const tableBody=document.querySelector("#tFilter tbody");tableBody.innerHTML=`
<tr>
<td colspan="9" class="text-center">Tidak ada data</td>
</tr>
`}}else{console.error("Gagal mengambil data:",result.message)}}catch(error){console.error("Error fetching data:",error)}}
function deletePlan(planName){if(confirm("Apakah anda yakin ingin menghapus plan "+planName+"?")){$.ajax({url:"../backend/delplan.php",type:"GET",data:{id:planName},success:function(response){location.reload()},error:function(xhr,status,error){console.error("Terjadi kesalahan:",error)},})}}
/**function editPlan(id){window.location.href=`../pppoe/edit_profile.php?id=${id}`} */
document.addEventListener("DOMContentLoaded",fetchData)

