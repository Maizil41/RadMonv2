/**
 * Radius Monitor Themes Change
 * Author : Maizil <https://github.com/maizil41>
 */
function changeTheme(tema){localStorage.setItem('userTheme',tema);window.location.href=`?themes=${tema}`}
window.onload=function(){const userTheme=localStorage.getItem('userTheme')||'blue';document.getElementById('themeSelector').value=userTheme;const themeSelector=document.getElementById('themeSelector');if(themeSelector.value!==""){setTimeout(()=>{themeSelector.value=""},100)}}