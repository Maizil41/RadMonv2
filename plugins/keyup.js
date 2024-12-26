/**
 * Radius Monitor Search
 * Author : Maizil <https://github.com/maizil41>
 */
$(document).ready(function(){makeAllSortable();$("#filterTable").on("keyup",function(){var value=$(this).val().toLowerCase();$("#dataTable tbody tr").filter(function(){$(this).toggle($(this).text().toLowerCase().indexOf(value)>-1)})})})