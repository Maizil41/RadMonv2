/**
 * Radius Monitor Report
 * Made by Maizil <https://github.com/maizil41>
 */
function confirmDelete(){var confirmAction=confirm("Apakah Anda yakin ingin menghapus data yang sudah difilter?");if(confirmAction){var url="?themes=' . $theme . '&delete=true&year=' . $year_filter . '&month=' . $month_filter . '&day=' . $day_filter . '";window.location.href=url}}
function filterR(){var day=document.getElementById("D").value;var month=document.getElementById("M").value;var year=document.getElementById("Y").value;var url="../hotspot/report.php?report=selling";if(day){url+="&day="+day}
if(month){url+="&month="+month}
if(year){url+="&year="+year}
window.location.href=url}
$(document).ready(function(){makeAllSortable();$("#filterTable").on("keyup",function(){var value=$(this).val().toLowerCase();$("#dataTable tbody tr").filter(function(){$(this).toggle($(this).text().toLowerCase().indexOf(value)>-1)})})});