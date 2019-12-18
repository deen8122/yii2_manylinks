$(function() {
    
    $('.nav-tabs a').click(function(){
		var hash = $(this).attr('href');
                var hashId = hash.substr(1);
                window.location.hash= hash;
		//alert(hash);
	});
        
      // alert(window.location.hash); 
       var hash = window.location.hash;
         $('a[href$="'+hash+'"]').click();
});