(function() {

    
var files = document.head.querySelectorAll('noscript.lh_css_lazy_load-file');

if (document.head.getElementsByTagName('link')){



var firstlink = document.head.getElementsByTagName('link')[0];

for (i = 0; i < files.length; i++) { 
    
var nosHtml = files[i].textContent||files[i].innerHTML; 

if ( nosHtml ){


document.head.insertAdjacentHTML('beforeend', nosHtml);


    

}
    
}

}



})();