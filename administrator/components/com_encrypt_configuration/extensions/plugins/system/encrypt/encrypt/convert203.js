
function encrypt_plugin_redundacy_check(s)
{
   var i;
   var sum = 0;
   for(i = 0; i < s.length; i++)
   {
      sum += s.charCodeAt(i);
   }
   var a="0123456789abcdef";
   var hex = '';
   hex += a.charAt((sum & 0xF0) >> 4) + a.charAt(sum & 0x0F);
   return hex;	
}

function encrypt_plugin_encryptValue(value)
{
	return plgEncrypt_rsaObject.encrypt(encrypt_plugin_redundacy_check(value) + value);
}

function encrypt_plugin_getElementByNameAndId(name, id)
{
	var coll = document.getElementsByName(name);
	var items = new Array();
	var i;
	for(i = 0; i < coll.length; i++)
	{
		if(coll.item(i).id == id)
			items.push( coll.item(i) );
	}
	return items;
}

function encrypt_plugin_get_parent_form(control, formName, formId)
{
	var forms = encrypt_plugin_getElementByNameAndId(formName, formId);
	for(var f = 0; f < forms.length; f++)
	{
		var form = forms[f];
		var i;
		for(i = 0; i < form.elements.length; i++)
		{
			if(form.elements.item(i) == control)
				return form;
		}
	}
	return null;
}

function encrypt_plugin_show_encrypt_signal(control)
{
	var x = encrypt_plugin_getAbsXCoord(control);
	var y = encrypt_plugin_getAbsYCoord(control);
	var div = document.createElement('DIV');
	document.body.appendChild(div);
	div.innerHTML = plgEncrypt_EncryptedSignal;
	div.style.backgroundColor = '#ffffff';
	div.style.border = '1px dotted';
	div.style.position = 'absolute';
	div.style.visibility = 'visible';
	div.style.left = x + 'px';
	div.style.top = y + 'px';
}

function encrypt_plugin_getPositionType(element)
{
	if(window.getComputedStyle)
		return window.getComputedStyle(element,null).position;
	else if(element.currentStyle)
		return element.currentStyle.position;
	else
		return 'static';
}

function encrypt_plugin_getAbsXCoord(element)
{
    var x = 0;
	var node = element;
    while(node != null && encrypt_plugin_getPositionType(node) == 'static')
    {
        x += node.offsetLeft;
        node = node.offsetParent;
    }
    return x;
}

function encrypt_plugin_getAbsYCoord(element)
{
    var y = 0;
	var node = element;
    while(node != null && encrypt_plugin_getPositionType(node) == 'static')
    {
        y += node.offsetTop;
        node = node.offsetParent;
    }
    return y;
}


function encrypt_plugin_checkParentForm(control, form)
{
	var node = control;
	while(node != null)
	{
		if(node == form)
			return true;
		node = node.parentNode;
	}
	return false;
}

function encrypt_plugin_getParentForm(control)
{
	var node = control;
	while(node != null)
	{
		if(node.nodeName == "FORM")
			return node;
		node = node.parentNode;
	}
	return null;
}

function encrypt_plugin_getElementByNameIdAndForm(name, id, form)
{
	var coll = document.getElementsByName(name);
	var items = new Array();
	var i;
	for(i = 0; i < coll.length; i++)
	{
		if(coll.item(i).id == id)
		{
			if(encrypt_plugin_checkParentForm(coll.item(i), form))
				return coll.item(i);
		}
	}
	return null;
}

function encrypt_plugin_removeBrackets(str)
{
	str = str.replace(/\[/g, '');
	str = str.replace(/\]/g, '');
	return str;
}

function encrypt_plugin_encryptform(formName, formId, form)
{
	var i;
	form = encrypt_plugin_getParentForm(form);
	for(i = 0; i < plgEncrypt_controls.length; i++)
	{
		if(plgEncrypt_controls[i].formName == formName && plgEncrypt_controls[i].formid == formId 
			&& !plgEncrypt_controls[i].encrypted)
		{
			var control = encrypt_plugin_getElementByNameIdAndForm(
				plgEncrypt_controls[i].controlName, 
				plgEncrypt_controls[i].controlId, form);
			if(control != null)
			{
				var encrypted = false;
				var dest_name = 'encrypted_' + 
					plgEncrypt_controls[i].formName + '_' + plgEncrypt_controls[i].formid + '_' +
					encrypt_plugin_removeBrackets(plgEncrypt_controls[i].controlName) + '_' + 
					plgEncrypt_controls[i].controlId;
				var token_name = 'formtoken_' + plgEncrypt_controls[i].formName  + '_' + 
					plgEncrypt_controls[i].formid;
				var dest_control = encrypt_plugin_getElementByNameIdAndForm(dest_name, dest_name, form);
				var token = encrypt_plugin_getElementByNameIdAndForm(token_name, token_name, form);
				if(dest_control != null && token != null && dest_control.value == '')
				{
					if(plgEncrypt_controls[i].encryptEmpty || (control.value != '' && control.value.length >= plgEncrypt_controls[i].minLength))
					{
						encrypted = true;
						dest_control.value = encrypt_plugin_encryptValue(token.value + ':' +control.value);
					}
				}
				if(encrypted)
				{
					control.setAttribute('autocomplete', 'off');
					control.value = 'rE34f@fffrE34f@fffrE34f@fffrE34f@fff';
					plgEncrypt_controls[i].encrypted = true;
					if(plgEncrypt_controls[i].showSignal)
						encrypt_plugin_show_encrypt_signal(control);
				}
			}
		}
	}
}
