
function checkform()
{
	return true;
	if (document.addform.categoryid.value == '') {
		alert('Please enter student category...');
		return false;
	}else{
		return true;
	}
	
}
