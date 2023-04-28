
function openChanges()
{
	document.getElementById("userName").removeAttribute('readonly');
	document.getElementById("userLastName").removeAttribute('readonly');
	document.getElementById("userLogin").removeAttribute('readonly');
	document.getElementById("change").style.display = "none";
	document.getElementById("save").style.display = "inline-flex";
	document.getElementById("reset").style.display = "inline-flex";
}

function hide()
{
	document.getElementById("userName").setAttribute('readonly', true);
	document.getElementById("userLastName").setAttribute('readonly', true);
	document.getElementById("userLogin").setAttribute('readonly', true);
	document.getElementById("change").style.display = "inline-flex";
	document.getElementById("save").style.display = "none";
	document.getElementById("reset").style.display = "none";
}