/**
 * Radius Monitor Batch List
 * Author : Maizil <https://github.com/maizil41>
 */
async function fetchBatchData(){try{document.getElementById("loading").style.display="block";document.querySelector(".main-container").style.display="none";const response=await fetch("../backend/quickPrint.php");const data=await response.json();const container=document.getElementById("batch-container");const colors=["bg-pink","bg-blue","bg-green","bg-yellow","bg-red","bg-orange","bg-purple","bg-teal","bg-indigo","bg-cyan"];data.forEach((batch)=>{const batchCard=document.createElement("div");batchCard.classList.add("col-4");const randomColor=colors[Math.floor(Math.random()*colors.length)];const accountsStr=batch.accounts.map((account)=>`${account.username},${account.password}`).join("||");batchCard.innerHTML=`        
<div class="quick box bmh-75 box-bordered ${randomColor}" title="Print Batch ${batch.batch_name}">
<div class="box-group">
<div class="box-group-icon">
<i class="fa fa-print pointer" onclick="openPrintWindow('${batch.plan_name}', '${accountsStr}', '${batch.batch_name}', ${batch.total_user})"></i>
<i class="fa fa-trash pointer" onclick="deleteBatch('${batch.batch_id}', '${batch.batch_name}')"></i>
</div>
<div class="box-group-area">
<h3>Batch Name : ${batch.batch_name} <br></h3>
<span>Plan Name : ${batch.plan_name}</span><br>
<span>Creation Date : ${batch.creationdate}</span><br>
<span>Total Users: ${batch.total_user}</span>
</div>
</div>
</div>
`;container.appendChild(batchCard)});document.getElementById("loading").style.display="none";document.querySelector(".main-container").style.display="block"}catch(error){console.error("Error fetching data:",error)}}
function openPrintWindow(planName,accountsStr,batchName,totalUser){if(totalUser===0){alert("Tidak ditemukan kode voucher untuk batch ini");return}
const selectedOption=document.getElementById("prinMode").value;const validOptions=["printTickets1.php","printTickets2.php","printTickets3.php","printTickets4.php"];if(!validOptions.includes(selectedOption)){alert("Pilihan tidak valid!");return}
const url=`./${selectedOption}?type=batch&plan=${planName}&accounts=Username,Password||${accountsStr}`;const newWindow=window.open(url,"_blank","width=800,height=600,scrollbars=yes");newWindow.onload=function(){newWindow.print()}}
function deleteBatch(batchId,batchName){if(confirm("Apakah anda yakin ingin menghapus batch "+batchName+"?")){$.ajax({url:"../backend/delbatch.php",type:"GET",data:{id:batchId},success:function(){location.reload()},error:function(xhr,status,error){console.error("Terjadi kesalahan:",error);alert("Terjadi kesalahan saat menghapus batch")},})}}
fetchBatchData()
