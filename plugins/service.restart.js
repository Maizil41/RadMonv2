/**
 * Radius Monitor Service Restart
 * Author : Maizil <https://github.com/maizil41>
 */
function confirmRestart(serviceName){if(confirm(`Apakah Anda yakin ingin merestart ${serviceName}?`)){fetch(`../backend/service.php?service=${serviceName}`).then(response=>response.text()).then(data=>{location.reload()}).catch(error=>{alert("Terjadi kesalahan: "+error)})}}
