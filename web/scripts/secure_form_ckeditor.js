/* 
 * @author Anthony Bocci
 */


//If the navigator doesn't allow cookies
if ( !navigator.cookieEnabled )
    alert('You have to enable cookies');
else { //Create a cookie
    var date = new Date();
    date.setTime(date.getTime()+(3600*1000));
    document.cookie = "jsEnabled=true; exprires="+date.toGMTString()+"; path=/";
}



