function validateSearchResultForm(alert_msg_min){
	var rmsavailable  = document.getElementsByName('room_list[]');	
	for(var i = 0; i < rmsavailable.length; i++){
		if(rmsavailable[i].value != 0){
			return true;
		}
	}		
	alert (alert_msg_min);
	return false;	
} 