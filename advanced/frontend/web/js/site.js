$(document).ready(function(){
	var f=0;
	$('.table td:nth-child(4) ').each(function(){
		if($(this).text()!=false){
			$(this).prepend("<div class='color_line' style='background:"+$(this).text()+"; ' ></div>");
			f=1;
		}
	});
	if(f==0){
		$('.but_down').hide();
	}
});

