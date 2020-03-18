function getHttpRequest()
{ var req = null; try
{ req = new XMLHttpRequest();}
catch(err1)
{ try
{ req = new ActiveXObject("Msxml2.XMLHTTP");}
catch (err2)
{ try
{ req = new ActiveXObject("Microsoft.XMLHTTP");}
catch (err3)
{ req = false;}
}
}
return req;}
var httpRequest = getHttpRequest(); var rsaProgressCancelRequested = false; function async_call(url, params, response)
{ if(params != '')
url += params; url += '&rand=' + parseInt(Math.random()*999999999999999); httpRequest.open("GET", url, true); httpRequest.onreadystatechange = response; httpRequest.send(null);}
function clearText(text)
{ var s = text.indexOf('('); var e = text.indexOf(')'); if(e > s)
return text.substr(s + 1, e - s - 1); else
return '';}
function genResponse()
{ if(httpRequest.readyState == 4)
{ if(httpRequest.status == 200)
{ var text = clearText(httpRequest.responseText); 
	var values = text.split(','); var progress = ""; var finished = false; var success = false; if(rsaProgressCancelRequested)
{ progress = encrypt_gen_msg_cancelled; finished = true;}
else
if(values[0] == '-1')
{ progress = encrypt_gen_msg_gen_error; finished = true;}
else if(values[0] == '1')
{ progress = encrypt_gen_msg_finished; finished = true; success = true;}

if(finished)
{ if(success)
{ document.location.href = "index.php?option=com_encrypt_configuration&task=keys";}
else
{ var btnRSAGenerate = document.getElementById('btnRSAGenerate'); var btnRSACancel = document.getElementById('btnRSACancel'); btnRSAGenerate.disabled = false; btnRSACancel.disabled = true; }
}
else
{ async_call('', 'index.php?option=com_encrypt_configuration&format=raw&task=gen', genResponse);}
var divProgress = document.getElementById('divRSAProgress'); if(divProgress != null)
divProgress.innerHTML = progress;}
else
{ alert(encrypt_gen_msg_connection_error);}
}
}
function genRSAProcess(url)
{ 
	rsaProgressCancelRequested = false; 
	var keyLengthEl = document.getElementById('keylength'); 
	var btnGenerate = document.getElementById('btnRSAGenerate'); 
	var btnRSACancel = document.getElementById('btnRSACancel'); 
	var divProgress = document.getElementById('divRSAProgress'); 
	if(keyLengthEl != null && btnGenerate != null && divProgress != null && btnRSACancel != null)
	{ 
		var keyLength = parseInt(keyLengthEl.value); 
		if(keyLength > 127 && keyLength <= 9048)
		{ 
			btnGenerate.disabled = true; 
			btnRSACancel.disabled = false; 
			divProgress.innerHTML = encrypt_gen_msg_generating; 
			async_call(url, 'index.php?option=com_encrypt_configuration&format=raw&task=gen&kl=' + keyLength, genResponse);
		}
		else
			alert(encrypt_gen_msg_invalid_key_length);
	}
}
function cancelRSAProcess()
{ rsaProgressCancelRequested = true;}
