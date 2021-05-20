$(document).ready(function() {
  $('.loading-bar').fadeIn(500);
  function time_out() {
    $('.loading-bar').fadeOut(500);
  }
  setTimeout(time_out, 500);

  $(window).on('load resize', function(){
    if($(window).width() < 568) {
      $('i.fa.fa-chain-broken.txt-blue').click(function(){
        $("body,html").animate({
          scrollTop:0
        }, 800);
        return false;
      });
    }
    
  });

  /* $('.header').prepend('<a href="#" class="open-menu"><span></span><span></span><span></span></a>'); */
});

function fl_authuser() {     
  var se_password = $('#se_password').val();      
  if ($('#se_remember').is(':checked'))  var se_remember = 1; else var se_remember = 0; 

  if(se_password == "") {
    $('#se_password').focus();
    return false;
  } 
  $.ajax({
    cache: false, 
    url: "ajax.php", 
    type: "POST",
    dataType: "json", 
    data: {"se_mode": 1, "se_password": se_password, "se_remember": se_remember},		   
    beforeSend: function() {	
      $('#loading').html('<span class="btn-medium gray"><i class="fa fa-spinner fa-spin"></i> Ждите...</span>');
	},
	success: function(data) {
      if(data.result == "success") {			   		           	              
        document.location.href = '/setraffic/';
	    return true;
	  }else{
        $('#loading').html('<span class="btn-medium red"><i class="fa fa-close"></i> '+ data.code +'</span>');
		function time_out() {
          $('#loading').html('<span class="btn-medium yellow" onclick="fl_authuser();">Войти</span>');		  
        }
        setTimeout(time_out, 2000);
		return false;
	  }		  
	}
  });	
return false;   
}

function fl_exit() {
  $.ajax({
    cache: false, 
    url: "ajax.php", 
    type: "POST",
    dataType: "json", 
    data: {"se_mode": 2},		   
    beforeSend: function() {	
      
	},
	success: function(data) {
      if(data.result == "success") {			   		           	              
        document.location.href = '/setraffic/';
	    return true;
	  }	   
	}
  });	
return false;
}

function fl_testlink(url) {
  $.ajax({
    cache: false, 
    url: "ajax.php", 
    type: "POST",
    dataType: "json", 
    data: {"se_mode": 4},		   
    beforeSend: function() {	
	},
	success: function(data) {
      if(data.result == "success") {			   		           	              
        if (document.getElementById('link').style.display == 'none') {
		   $('#link').fadeToggle('duration');
        }
		$('#link-url').val(url+'/?hash='+ data.html);	    
		return true;
	  }else{
        alert(data.code);
		return false;
      }		  
	}
  });	
return false;
}

function fl_status(stat) {  
  $.ajax({
    cache: false, 
    url: "ajax.php", 
    type: "POST",
    dataType: "json", 
    data: {"se_mode": 3, "se_val": stat},		   
    beforeSend: function() {	

	},
	success: function(data) {
      if(data.result == "success") 
	  {			   		           	              
        if(stat == 1) {
	      $('#fl_1').html('<i class="fa fa-toggle-on txt-green" onclick="fl_status(0);" title="Выключить фильтр"></i>'); 
	    } else {	
	      $('#fl_1').html('<i class="fa fa-toggle-off txt-red" onclick="fl_status(1);" title="Включить фильтр"></i>');
	    }
	    return true;
	  }else{
        alert(data.code);
		return false;
      }		  
	}
  });	
return false;	
}

function fl_info(e) {
    if (document.getElementById('info-'+ e).style.display == 'none') {
        $('#info-'+ e).fadeToggle('duration');
		$('#eye-'+ e).html('<i class="fa fa-eye-slash txt-gray" title="Скрыть все данные о посещении"></i>');    
    }else{
        $('#info-'+ e).fadeOut(300);
	    $('#eye-'+ e).html('<i class="fa fa-eye txt-gray" title="Показать все данные о посещении"></i>');
    }	    
    return false;	
}

function fl_ublock(e) {
    var step;
	for (step = 0; step < 15; step++) {
	   if(step == e) {
		  $('#ublock-'+ e).fadeToggle('duration');		
          $('#active-'+ e).addClass("active");
		  if(e < 10) {
		     document.cookie = '_se_tokken_conf='+ e;
		  }else{
			 document.cookie = '_se_tokken_prof='+ e;  
		  }
	   }else{
		  $('#ublock-'+ step).fadeOut(0);
		  $('#active-'+ step).removeClass("active");   
	   }
	}	    
return false;	
}

function fl_help(e) {
    if (document.getElementById('help-'+ e).style.display == 'none') {
        $('#help-'+ e).fadeToggle('duration');
		$('#hl-'+ e).html('<i class="fa fa-question-circle txt-yellow" title="Скрыть подказку"></i>');  
    } else {
        $('#help-'+ e).fadeOut(300);
		$('#hl-'+ e).html('<i class="fa fa-question-circle txt-gray" title="Показать подказку"></i>');
    }	    
    return false;	
}

function fl_copylink() {
   var copyText = document.getElementById("link-url");
   copyText.select();
   document.execCommand("copy"); 
   $('#link-btn').html('<span class="btn-small gray"><i class="fa fa-files-o"></i> Готово</span>');
   function time_out() {
      $('#link-btn').html('<span class="btn-small blue" onclick="fl_copylink();"><i class="fa fa-files-o"></i> Копировать</span>');		  
   }
   setTimeout(time_out, 1000);   
   return true;   
}

function postform() {
    document.forms['sendform'].submit();
    return true;
}

function se_addcountry(id) { 
  var str = $('#se_listcountry').val();  
  if($('#'+ id).hasClass("country selok")) { 	 
	 if(str.lastIndexOf('|'+ id) >= 0) {          
		var tx = str.replace('|'+ id,"");
		$('#se_listcountry').empty();
		$('#se_listcountry').append(tx);         
	 }else if(str.lastIndexOf(id) >= 0) {            
		var tx = str.replace(id +'|',"");
		var tx = str.replace(id,"");
		$('#se_listcountry').empty();
	    $('#se_listcountry').append(tx);
     }
     $('#'+ id).removeClass('selok');
  }else{	   		
     if(str.length == 0) {          		  
		$('#se_listcountry').append(id);		   
	 }else{           
	    $('#se_listcountry').append('|'+ id); 		   
     }
     $('#'+ id).addClass('selok');
  }
return false;	
} 

function fl_cleanip() { 
  if (confirm("Вы уверены, что хотите очистить список IP, попавшие под Timeout?")) {   
    $.ajax({
      cache: false, 
      url: "ajax.php", 
      type: "POST",
      dataType: "json", 
      data: {"se_mode": 5},		   
      beforeSend: function() {	
	  
	  },
	  success: function(data) {
        if(data.result == "success") {		  
          $('#se_timeout').empty();
		  return true;
	    }else{
		  alert(data.code);   
		  return false;
	    }		  
	  }
    });
  }  
return false;
}
function fl_deactive() {   
    $.ajax({
      cache: false, 
      url: "ajax.php", 
      type: "POST",
      dataType: "json", 
      data: {"se_mode": 6},		   
      beforeSend: function() {	
	  
	  },
	  success: function(data) {
        if(data.result == "success") {		  
          window.location.reload();
		  return true;
	    }else{
		  alert(data.code);   
		  return false;
	    }		  
	  }
    }); 
return false;
}
// Вопросы и ответы
function fl_faq(e) {
   if (document.getElementById('answer-'+ e).style.display == 'none') {
	  $('#answer-'+ e).fadeToggle('duration');   
   } else {
      $('#answer-'+ e).fadeOut(300);
   }	    
   return false;	
}