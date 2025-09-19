/**
 * Radius Monitor Batch List
 * Author : Maizil <https://github.com/maizil41>
 */
async function fetchBatchData(){try{document.getElementById("loading").style.display="block";document.querySelector(".main-container").style.display="none";const response=await fetch("../backend/quickPrint.php");const data=await response.json();const container=document.getElementById("batch-container");const colors=["bg-primary","bg-secondary","bg-success","bg-info","bg-warning","bg-danger","bg-blue","bg-indigo","bg-purple","bg-pink","bg-red","bg-orange","bg-yellow","bg-green","bg-teal","bg-cyan","bg-grey","bg-light-blue"];data.forEach((batch)=>{const batchCard=document.createElement("div");batchCard.classList.add("col-4");const randomColor=colors[Math.floor(Math.random()*colors.length)];const accountsStr=batch.accounts.map((account)=>`${account.username},${account.password}`).join("||");batchCard.innerHTML=`        
<div class="quick box bmh-75 box-bordered ${randomColor}">
<div class="box-group">
<div class="box-group-icon">
<i class="fa fa-print pointer" title="Print Batch ${batch.batch_name}" onclick="openPrintWindow('${batch.batch_id}', '${batch.batch_name}', ${batch.total_user})"></i>
<i class="fa fa-trash pointer" title="Delete Batch ${batch.batch_name}" onclick="deleteBatch('${batch.batch_id}', '${batch.batch_name}')"></i>
</div>
<div class="box-group-area">
<h3>Name: ${batch.batch_name} <br></h3>
<span>Profile: ${batch.plan_name}</span><br>
<span>Date: ${batch.creationdate}</span><br>
<span>Time: ${batch.creationtime}</span><br>
<span>Total: ${batch.total_user}</span>
</div>
</div>
</div>
`;container.appendChild(batchCard)});document.getElementById("loading").style.display="none";document.querySelector(".main-container").style.display="block"}catch(error){console.error("Error fetching data:",error)}}
function openPrintWindow(batchId,batchName,totalUser){if(totalUser===0){alert("Tidak ditemukan kode voucher untuk batch ini");return}
const selectedOption=document.getElementById("prinMode").value;const validOptions=["printTickets1.php","printTickets2.php","printTickets3.php","printTickets4.php"];if(!validOptions.includes(selectedOption)){alert("Pilihan tidak valid!");return}
const url=`./${selectedOption}?id=${batchId}&batch=${batchName}`;const newWindow=window.open(url,"_blank");newWindow.onload=function(){newWindow.print()}}
function deleteBatch(batchId,batchName){if(confirm("Apakah anda yakin ingin menghapus batch "+batchName+"?")){$.ajax({url:"../backend/delbatch.php",type:"GET",data:{id:batchId},success:function(){location.reload()},error:function(xhr,status,error){console.error("Terjadi kesalahan:",error);alert("Terjadi kesalahan saat menghapus batch")},})}}
fetchBatchData()
