/* 
 * @author Anthony Bocci
 */

/**
 *changeLanguageToFrench() change the locale parameter
 * to french 
 * @returns {undefined}
 */
 function changeLanguageToFrench() {
    var path = document.location.href;
    //If the website is in english, change to french
    if ( path.indexOf('/en/') !== -1 ) {
        path = path.replace('/en/', '/fr/');
        window.location.replace(path);
    }
 }
            
/**
 * changeLanguageToEnglish() change the locale parameter
 * to english
 * @returns {undefined}
 */
 function changeLanguageToEnglish() {
    var path = document.location.href;
    //If the website is in french, change to english
    if ( path.indexOf('/fr/') !== -1 ) {
        path = path.replace('/fr/', '/en/');
        window.location.replace(path);
    }
 }

