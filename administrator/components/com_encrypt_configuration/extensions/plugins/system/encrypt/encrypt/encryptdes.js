//Paul Tero, July 2001
//http://www.tero.co.uk/des/
function des (key, message, encrypt, mode, iv, padding) { var spfunction1 = new Array (0x1010400,0,0x10000,0x1010404,0x1010004,0x10404,0x4,0x10000,0x400,0x1010400,0x1010404,0x400,0x1000404,0x1010004,0x1000000,0x4,0x404,0x1000400,0x1000400,0x10400,0x10400,0x1010000,0x1010000,0x1000404,0x10004,0x1000004,0x1000004,0x10004,0,0x404,0x10404,0x1000000,0x10000,0x1010404,0x4,0x1010000,0x1010400,0x1000000,0x1000000,0x400,0x1010004,0x10000,0x10400,0x1000004,0x400,0x4,0x1000404,0x10404,0x1010404,0x10004,0x1010000,0x1000404,0x1000004,0x404,0x10404,0x1010400,0x404,0x1000400,0x1000400,0,0x10004,0x10400,0,0x1010004); var spfunction2 = new Array (-0x7fef7fe0,-0x7fff8000,0x8000,0x108020,0x100000,0x20,-0x7fefffe0,-0x7fff7fe0,-0x7fffffe0,-0x7fef7fe0,-0x7fef8000,-0x80000000,-0x7fff8000,0x100000,0x20,-0x7fefffe0,0x108000,0x100020,-0x7fff7fe0,0,-0x80000000,0x8000,0x108020,-0x7ff00000,0x100020,-0x7fffffe0,0,0x108000,0x8020,-0x7fef8000,-0x7ff00000,0x8020,0,0x108020,-0x7fefffe0,0x100000,-0x7fff7fe0,-0x7ff00000,-0x7fef8000,0x8000,-0x7ff00000,-0x7fff8000,0x20,-0x7fef7fe0,0x108020,0x20,0x8000,-0x80000000,0x8020,-0x7fef8000,0x100000,-0x7fffffe0,0x100020,-0x7fff7fe0,-0x7fffffe0,0x100020,0x108000,0,-0x7fff8000,0x8020,-0x80000000,-0x7fefffe0,-0x7fef7fe0,0x108000); var spfunction3 = new Array (0x208,0x8020200,0,0x8020008,0x8000200,0,0x20208,0x8000200,0x20008,0x8000008,0x8000008,0x20000,0x8020208,0x20008,0x8020000,0x208,0x8000000,0x8,0x8020200,0x200,0x20200,0x8020000,0x8020008,0x20208,0x8000208,0x20200,0x20000,0x8000208,0x8,0x8020208,0x200,0x8000000,0x8020200,0x8000000,0x20008,0x208,0x20000,0x8020200,0x8000200,0,0x200,0x20008,0x8020208,0x8000200,0x8000008,0x200,0,0x8020008,0x8000208,0x20000,0x8000000,0x8020208,0x8,0x20208,0x20200,0x8000008,0x8020000,0x8000208,0x208,0x8020000,0x20208,0x8,0x8020008,0x20200); var spfunction4 = new Array (0x802001,0x2081,0x2081,0x80,0x802080,0x800081,0x800001,0x2001,0,0x802000,0x802000,0x802081,0x81,0,0x800080,0x800001,0x1,0x2000,0x800000,0x802001,0x80,0x800000,0x2001,0x2080,0x800081,0x1,0x2080,0x800080,0x2000,0x802080,0x802081,0x81,0x800080,0x800001,0x802000,0x802081,0x81,0,0,0x802000,0x2080,0x800080,0x800081,0x1,0x802001,0x2081,0x2081,0x80,0x802081,0x81,0x1,0x2000,0x800001,0x2001,0x802080,0x800081,0x2001,0x2080,0x800000,0x802001,0x80,0x800000,0x2000,0x802080); var spfunction5 = new Array (0x100,0x2080100,0x2080000,0x42000100,0x80000,0x100,0x40000000,0x2080000,0x40080100,0x80000,0x2000100,0x40080100,0x42000100,0x42080000,0x80100,0x40000000,0x2000000,0x40080000,0x40080000,0,0x40000100,0x42080100,0x42080100,0x2000100,0x42080000,0x40000100,0,0x42000000,0x2080100,0x2000000,0x42000000,0x80100,0x80000,0x42000100,0x100,0x2000000,0x40000000,0x2080000,0x42000100,0x40080100,0x2000100,0x40000000,0x42080000,0x2080100,0x40080100,0x100,0x2000000,0x42080000,0x42080100,0x80100,0x42000000,0x42080100,0x2080000,0,0x40080000,0x42000000,0x80100,0x2000100,0x40000100,0x80000,0,0x40080000,0x2080100,0x40000100); var spfunction6 = new Array (0x20000010,0x20400000,0x4000,0x20404010,0x20400000,0x10,0x20404010,0x400000,0x20004000,0x404010,0x400000,0x20000010,0x400010,0x20004000,0x20000000,0x4010,0,0x400010,0x20004010,0x4000,0x404000,0x20004010,0x10,0x20400010,0x20400010,0,0x404010,0x20404000,0x4010,0x404000,0x20404000,0x20000000,0x20004000,0x10,0x20400010,0x404000,0x20404010,0x400000,0x4010,0x20000010,0x400000,0x20004000,0x20000000,0x4010,0x20000010,0x20404010,0x404000,0x20400000,0x404010,0x20404000,0,0x20400010,0x10,0x4000,0x20400000,0x404010,0x4000,0x400010,0x20004010,0,0x20404000,0x20000000,0x400010,0x20004010); var spfunction7 = new Array (0x200000,0x4200002,0x4000802,0,0x800,0x4000802,0x200802,0x4200800,0x4200802,0x200000,0,0x4000002,0x2,0x4000000,0x4200002,0x802,0x4000800,0x200802,0x200002,0x4000800,0x4000002,0x4200000,0x4200800,0x200002,0x4200000,0x800,0x802,0x4200802,0x200800,0x2,0x4000000,0x200800,0x4000000,0x200800,0x200000,0x4000802,0x4000802,0x4200002,0x4200002,0x2,0x200002,0x4000000,0x4000800,0x200000,0x4200800,0x802,0x200802,0x4200800,0x802,0x4000002,0x4200802,0x4200000,0x200800,0,0x2,0x4200802,0,0x200802,0x4200000,0x800,0x4000002,0x4000800,0x800,0x200002); var spfunction8 = new Array (0x10001040,0x1000,0x40000,0x10041040,0x10000000,0x10001040,0x40,0x10000000,0x40040,0x10040000,0x10041040,0x41000,0x10041000,0x41040,0x1000,0x40,0x10040000,0x10000040,0x10001000,0x1040,0x41000,0x40040,0x10040040,0x10041000,0x1040,0,0,0x10040040,0x10000040,0x10001000,0x41040,0x40000,0x41040,0x40000,0x10041000,0x1000,0x40,0x10040040,0x1000,0x41040,0x10001000,0x40,0x10000040,0x10040000,0x10040040,0x10000000,0x40000,0x10001040,0,0x10041040,0x40040,0x10000040,0x10040000,0x10001000,0x10001040,0,0x10041040,0x41000,0x41000,0x1040,0x1040,0x40040,0x10000000,0x10041000); var keys = des_createKeys (key); var m=0, i, j, temp, temp2, right1, right2, left, right, looping; var cbcleft, cbcleft2, cbcright, cbcright2
var endloop, loopinc; var len = message.length; var chunk = 0; var iterations = keys.length == 32 ? 3 : 9; if (iterations == 3) {looping = encrypt ? new Array (0, 32, 2) : new Array (30, -2, -2);}
else {looping = encrypt ? new Array (0, 32, 2, 62, 30, -2, 64, 96, 2) : new Array (94, 62, -2, 32, 64, 2, 30, -2, -2);}
if (padding == 2) message += "        "; else if (padding == 1) {temp = 8-(len%8); message += String.fromCharCode (temp,temp,temp,temp,temp,temp,temp,temp); if (temp==8) len+=8;}
else if (!padding) message += "\0\0\0\0\0\0\0\0"; result = ""; tempresult = ""; if (mode == 1) { cbcleft = (iv.charCodeAt(m++) << 24) | (iv.charCodeAt(m++) << 16) | (iv.charCodeAt(m++) << 8) | iv.charCodeAt(m++); cbcright = (iv.charCodeAt(m++) << 24) | (iv.charCodeAt(m++) << 16) | (iv.charCodeAt(m++) << 8) | iv.charCodeAt(m++); m=0;}
while (m < len) { left = (message.charCodeAt(m++) << 24) | (message.charCodeAt(m++) << 16) | (message.charCodeAt(m++) << 8) | message.charCodeAt(m++); right = (message.charCodeAt(m++) << 24) | (message.charCodeAt(m++) << 16) | (message.charCodeAt(m++) << 8) | message.charCodeAt(m++); if (mode == 1) {if (encrypt) {left ^= cbcleft; right ^= cbcright;} else {cbcleft2 = cbcleft; cbcright2 = cbcright; cbcleft = left; cbcright = right;}}
temp = ((left >>> 4) ^ right) & 0x0f0f0f0f; right ^= temp; left ^= (temp << 4); temp = ((left >>> 16) ^ right) & 0x0000ffff; right ^= temp; left ^= (temp << 16); temp = ((right >>> 2) ^ left) & 0x33333333; left ^= temp; right ^= (temp << 2); temp = ((right >>> 8) ^ left) & 0x00ff00ff; left ^= temp; right ^= (temp << 8); temp = ((left >>> 1) ^ right) & 0x55555555; right ^= temp; left ^= (temp << 1); left = ((left << 1) | (left >>> 31)); right = ((right << 1) | (right >>> 31)); for (j=0; j<iterations; j+=3) { endloop = looping[j+1]; loopinc = looping[j+2]; for (i=looping[j]; i!=endloop; i+=loopinc) { right1 = right ^ keys[i]; right2 = ((right >>> 4) | (right << 28)) ^ keys[i+1]; temp = left; left = right; right = temp ^ (spfunction2[(right1 >>> 24) & 0x3f] | spfunction4[(right1 >>> 16) & 0x3f] | spfunction6[(right1 >>> 8) & 0x3f] | spfunction8[right1 & 0x3f] | spfunction1[(right2 >>> 24) & 0x3f] | spfunction3[(right2 >>> 16) & 0x3f] | spfunction5[(right2 >>> 8) & 0x3f] | spfunction7[right2 & 0x3f]);}
temp = left; left = right; right = temp;}
left = ((left >>> 1) | (left << 31)); right = ((right >>> 1) | (right << 31)); temp = ((left >>> 1) ^ right) & 0x55555555; right ^= temp; left ^= (temp << 1); temp = ((right >>> 8) ^ left) & 0x00ff00ff; left ^= temp; right ^= (temp << 8); temp = ((right >>> 2) ^ left) & 0x33333333; left ^= temp; right ^= (temp << 2); temp = ((left >>> 16) ^ right) & 0x0000ffff; right ^= temp; left ^= (temp << 16); temp = ((left >>> 4) ^ right) & 0x0f0f0f0f; right ^= temp; left ^= (temp << 4); if (mode == 1) {if (encrypt) {cbcleft = left; cbcright = right;} else {left ^= cbcleft2; right ^= cbcright2;}}
tempresult += String.fromCharCode ((left>>>24), ((left>>>16) & 0xff), ((left>>>8) & 0xff), (left & 0xff), (right>>>24), ((right>>>16) & 0xff), ((right>>>8) & 0xff), (right & 0xff)); chunk += 8; if (chunk == 512) {result += tempresult; tempresult = ""; chunk = 0;}
}
return result + tempresult;}
function des_createKeys (key) { pc2bytes0 = new Array (0,0x4,0x20000000,0x20000004,0x10000,0x10004,0x20010000,0x20010004,0x200,0x204,0x20000200,0x20000204,0x10200,0x10204,0x20010200,0x20010204); pc2bytes1 = new Array (0,0x1,0x100000,0x100001,0x4000000,0x4000001,0x4100000,0x4100001,0x100,0x101,0x100100,0x100101,0x4000100,0x4000101,0x4100100,0x4100101); pc2bytes2 = new Array (0,0x8,0x800,0x808,0x1000000,0x1000008,0x1000800,0x1000808,0,0x8,0x800,0x808,0x1000000,0x1000008,0x1000800,0x1000808); pc2bytes3 = new Array (0,0x200000,0x8000000,0x8200000,0x2000,0x202000,0x8002000,0x8202000,0x20000,0x220000,0x8020000,0x8220000,0x22000,0x222000,0x8022000,0x8222000); pc2bytes4 = new Array (0,0x40000,0x10,0x40010,0,0x40000,0x10,0x40010,0x1000,0x41000,0x1010,0x41010,0x1000,0x41000,0x1010,0x41010); pc2bytes5 = new Array (0,0x400,0x20,0x420,0,0x400,0x20,0x420,0x2000000,0x2000400,0x2000020,0x2000420,0x2000000,0x2000400,0x2000020,0x2000420); pc2bytes6 = new Array (0,0x10000000,0x80000,0x10080000,0x2,0x10000002,0x80002,0x10080002,0,0x10000000,0x80000,0x10080000,0x2,0x10000002,0x80002,0x10080002); pc2bytes7 = new Array (0,0x10000,0x800,0x10800,0x20000000,0x20010000,0x20000800,0x20010800,0x20000,0x30000,0x20800,0x30800,0x20020000,0x20030000,0x20020800,0x20030800); pc2bytes8 = new Array (0,0x40000,0,0x40000,0x2,0x40002,0x2,0x40002,0x2000000,0x2040000,0x2000000,0x2040000,0x2000002,0x2040002,0x2000002,0x2040002); pc2bytes9 = new Array (0,0x10000000,0x8,0x10000008,0,0x10000000,0x8,0x10000008,0x400,0x10000400,0x408,0x10000408,0x400,0x10000400,0x408,0x10000408); pc2bytes10 = new Array (0,0x20,0,0x20,0x100000,0x100020,0x100000,0x100020,0x2000,0x2020,0x2000,0x2020,0x102000,0x102020,0x102000,0x102020); pc2bytes11 = new Array (0,0x1000000,0x200,0x1000200,0x200000,0x1200000,0x200200,0x1200200,0x4000000,0x5000000,0x4000200,0x5000200,0x4200000,0x5200000,0x4200200,0x5200200); pc2bytes12 = new Array (0,0x1000,0x8000000,0x8001000,0x80000,0x81000,0x8080000,0x8081000,0x10,0x1010,0x8000010,0x8001010,0x80010,0x81010,0x8080010,0x8081010); pc2bytes13 = new Array (0,0x4,0x100,0x104,0,0x4,0x100,0x104,0x1,0x5,0x101,0x105,0x1,0x5,0x101,0x105); var iterations = key.length > 8 ? 3 : 1; var keys = new Array (32 * iterations); var shifts = new Array (0, 0, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 0); var lefttemp, righttemp, m=0, n=0, temp; for (var j=0; j<iterations; j++) { left = (key.charCodeAt(m++) << 24) | (key.charCodeAt(m++) << 16) | (key.charCodeAt(m++) << 8) | key.charCodeAt(m++); right = (key.charCodeAt(m++) << 24) | (key.charCodeAt(m++) << 16) | (key.charCodeAt(m++) << 8) | key.charCodeAt(m++); temp = ((left >>> 4) ^ right) & 0x0f0f0f0f; right ^= temp; left ^= (temp << 4); temp = ((right >>> -16) ^ left) & 0x0000ffff; left ^= temp; right ^= (temp << -16); temp = ((left >>> 2) ^ right) & 0x33333333; right ^= temp; left ^= (temp << 2); temp = ((right >>> -16) ^ left) & 0x0000ffff; left ^= temp; right ^= (temp << -16); temp = ((left >>> 1) ^ right) & 0x55555555; right ^= temp; left ^= (temp << 1); temp = ((right >>> 8) ^ left) & 0x00ff00ff; left ^= temp; right ^= (temp << 8); temp = ((left >>> 1) ^ right) & 0x55555555; right ^= temp; left ^= (temp << 1); temp = (left << 8) | ((right >>> 20) & 0x000000f0); left = (right << 24) | ((right << 8) & 0xff0000) | ((right >>> 8) & 0xff00) | ((right >>> 24) & 0xf0); right = temp; for (var i=0; i < shifts.length; i++) { if (shifts[i]) {left = (left << 2) | (left >>> 26); right = (right << 2) | (right >>> 26);}
else {left = (left << 1) | (left >>> 27); right = (right << 1) | (right >>> 27);}
left &= -0xf; right &= -0xf; lefttemp = pc2bytes0[left >>> 28] | pc2bytes1[(left >>> 24) & 0xf] | pc2bytes2[(left >>> 20) & 0xf] | pc2bytes3[(left >>> 16) & 0xf] | pc2bytes4[(left >>> 12) & 0xf] | pc2bytes5[(left >>> 8) & 0xf] | pc2bytes6[(left >>> 4) & 0xf]; righttemp = pc2bytes7[right >>> 28] | pc2bytes8[(right >>> 24) & 0xf] | pc2bytes9[(right >>> 20) & 0xf] | pc2bytes10[(right >>> 16) & 0xf] | pc2bytes11[(right >>> 12) & 0xf] | pc2bytes12[(right >>> 8) & 0xf] | pc2bytes13[(right >>> 4) & 0xf]; temp = ((righttemp >>> 16) ^ lefttemp) & 0x0000ffff; keys[n++] = lefttemp ^ temp; keys[n++] = righttemp ^ (temp << 16);}
}
return keys;}
function stringToHex (s) { var r = "0x"; var hexes = new Array ("0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f"); for (var i=0; i<s.length; i++) {r += hexes [s.charCodeAt(i) >> 4] + hexes [s.charCodeAt(i) & 0xf];}
return r;}
function chr(code)
{ return String.fromCharCode(code);}
function code2utf(code)
{ if (code < 128) return chr(code); if (code < 2048) return chr(192+(code>>6)) + chr(128+(code&63)); if (code < 65536) return chr(224+(code>>12)) + chr(128+((code>>6)&63)) + chr(128+(code&63)); if (code < 2097152) return chr(240+(code>>18)) + chr(128+((code>>12)&63)) + chr(128+((code>>6)&63)) + chr(128+(code&63));}
function _utf8Encode(str)
{ var utf8str = new Array(); for (var i=0; i<str.length; i++) { utf8str[i] = code2utf(str.charCodeAt(i));}
return utf8str.join('');}
function utf8Encode(str)
{ var utf8str = new Array(); var pos,j = 0; var tmpStr = ''; while ((pos = str.search(/[^\x00-\x7F]/)) != -1) { tmpStr = str.match(/([^\x00-\x7F]+[\x00-\x7F]{0,10})+/)[0]; utf8str[j++] = str.substr(0, pos); utf8str[j++] = _utf8Encode(tmpStr); str = str.substr(pos + tmpStr.length);}
utf8str[j++] = str; return utf8str.join('');}
function _utf8Decode(utf8str)
{ var str = new Array(); var code,code2,code3,code4,j = 0; for (var i=0; i<utf8str.length; ) { code = utf8str.charCodeAt(i++); if (code > 127) code2 = utf8str.charCodeAt(i++); if (code > 223) code3 = utf8str.charCodeAt(i++); if (code > 239) code4 = utf8str.charCodeAt(i++); if (code < 128) str[j++]= chr(code); else if (code < 224) str[j++] = chr(((code-192)<<6) + (code2-128)); else if (code < 240) str[j++] = chr(((code-224)<<12) + ((code2-128)<<6) + (code3-128)); else str[j++] = chr(((code-240)<<18) + ((code2-128)<<12) + ((code3-128)<<6) + (code4-128));}
return str.join('');}
function utf8Decode(utf8str)
{ var str = new Array(); var pos = 0; var tmpStr = ''; var j=0; while ((pos = utf8str.search(/[^\x00-\x7F]/)) != -1) { tmpStr = utf8str.match(/([^\x00-\x7F]+[\x00-\x7F]{0,10})+/)[0]; str[j++]= utf8str.substr(0, pos) + _utf8Decode(tmpStr); utf8str = utf8str.substr(pos + tmpStr.length);}
str[j++] = utf8str; return str.join('');}
function encrypt_plugin_redundacy_check(s)
{ var i; var sum = 0; for(i = 0; i < s.length; i++)
{ sum += s.charCodeAt(i);}
var a="0123456789abcdef"; var hex = ''; hex += a.charAt((sum & 0xF0) >> 4) + a.charAt(sum & 0x0F); return hex;}
function encrypt_plugin_encryptValue(value)
{ value = utf8Encode(value); return stringToHex(des(key, encrypt_plugin_redundacy_check(value) + value, 1, 0));}
function encrypt_plugin_getElementByNameAndId(name, id)
{ var coll = document.getElementsByName(name); var items = new Array(); var i; for(i = 0; i < coll.length; i++)
{ if(coll.item(i).id == id)
items.push( coll.item(i) );}
return items;}
function encrypt_plugin_checkParentForm(control, form)
{ var node = control; while(node != null)
{ if(node == form)
return true; node = node.parentNode;}
return false;}
function encrypt_plugin_getParentForm(control)
{ var node = control; while(node != null)
{ if(node.nodeName == "FORM")
return node; node = node.parentNode;}
return null;}
function encrypt_plugin_getElementByNameIdAndForm(name, id, form)
{ var coll = document.getElementsByName(name); var items = new Array(); var i; for(i = 0; i < coll.length; i++)
{ if(coll.item(i).id == id)
{ if(encrypt_plugin_checkParentForm(coll.item(i), form))
return coll.item(i);}
}
return null;}
function encrypt_plugin_get_parent_form(control, formName, formId)
{ var forms = encrypt_plugin_getElementByNameAndId(formName, formId); for(var f = 0; f < forms.length; f++)
{ var form = forms[f]; var i; for(i = 0; i < form.elements.length; i++)
{ if(form.elements.item(i) == control)
return form;}
}
return null;}
function encrypt_plugin_show_encrypt_signal(control)
{ var x = encrypt_plugin_getAbsXCoord(control); var y = encrypt_plugin_getAbsYCoord(control); var div = document.createElement('DIV'); document.body.appendChild(div); div.innerHTML = plgEncrypt_EncryptedSignal; div.style.border = '1px dotted'; div.style.position = 'absolute'; div.style.visibility = 'visible'; div.style.backgroundColor = '#ffffff'; div.style.left = x + 'px'; div.style.top = y + 'px';}
function encrypt_plugin_getPositionType(element)
{ if(window.getComputedStyle)
return window.getComputedStyle(element,null).position; else if(element.currentStyle)
return element.currentStyle.position; else
return 'static';}
function encrypt_plugin_getAbsXCoord(element)
{ var x = 0; var node = element; while(node != null && encrypt_plugin_getPositionType(node) == 'static')
{ x += node.offsetLeft; node = node.offsetParent;}
return x;}
function encrypt_plugin_getAbsYCoord(element)
{ var y = 0; var node = element; while(node != null && encrypt_plugin_getPositionType(node) == 'static')
{ y += node.offsetTop; node = node.offsetParent;}
return y;}
function encrypt_plugin_removeBrackets(str)
{ str = str.replace(/\[/g, ''); str = str.replace(/\]/g, ''); return str;}
function encrypt_plugin_encryptform(formName, formId, form)
{ var i; form = encrypt_plugin_getParentForm(form); for(i = 0; i < plgEncrypt_controls.length; i++)
{ if(plgEncrypt_controls[i].formName == formName && plgEncrypt_controls[i].formid == formId
&& !plgEncrypt_controls[i].encrypted)
{ var control = encrypt_plugin_getElementByNameIdAndForm( plgEncrypt_controls[i].controlName, plgEncrypt_controls[i].controlId, form); if(control != null)
{ var encrypted = false; var dest_name = 'encrypted_' + plgEncrypt_controls[i].formName + '_' + plgEncrypt_controls[i].formid + '_' + encrypt_plugin_removeBrackets(plgEncrypt_controls[i].controlName) + '_' + plgEncrypt_controls[i].controlId; var token_name = 'formtoken_' + plgEncrypt_controls[i].formName + '_' + plgEncrypt_controls[i].formid; var dest_control = encrypt_plugin_getElementByNameIdAndForm(dest_name, dest_name, form); var token = encrypt_plugin_getElementByNameIdAndForm(token_name, token_name, form); if(dest_control != null && token != null && dest_control.value == '')
{ if(plgEncrypt_controls[i].encryptEmpty || (control.value != '' && control.value.length >= plgEncrypt_controls[i].minLength))
{ encrypted = true; dest_control.value = encrypt_plugin_encryptValue(token.value + ':' +control.value);}
}
if(encrypted)
{ control.setAttribute('autocomplete', 'off'); control.value = 'rE34f@fffrE34f@fffrE34f@fffrE34f@fff'; plgEncrypt_controls[i].encrypted = true; if(plgEncrypt_controls[i].showSignal)
encrypt_plugin_show_encrypt_signal(control);}
}
}
}
}
