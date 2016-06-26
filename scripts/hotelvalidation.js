function validateSearchResultForm(alert_msg_min){
	var rmsavailable  = document.getElementsByName('room_list[]');	
	//alert(rmsavailable.length);
	for(var i = 0; i < rmsavailable.length; i++){
		//alert(rmsavailable[i].value);
		if(rmsavailable[i].value > 0){
			return true;
		}
	}		
	alert (alert_msg_min);
	return false;	
} 
