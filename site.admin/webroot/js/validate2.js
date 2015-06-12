function mascaraMutuario(o,f){
    v_obj=o
    v_fun=f
    setTimeout('execmascara()',1)
}

function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}

function cpfCnpj(v){

    //Remove tudo o que n„o È dÌgito
    v=v.replace(/\D/g,"")

    if (v.length <= 11) { //CPF

        //Coloca um ponto entre o terceiro e o quarto dÌgitos
        v=v.replace(/(\d{3})(\d)/,"$1.$2")

        //Coloca um ponto entre o terceiro e o quarto dÌgitos
        //de novo (para o segundo bloco de n˙meros)
        v=v.replace(/(\d{3})(\d)/,"$1.$2")

        //Coloca um hÌfen entre o terceiro e o quarto dÌgitos
        v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2")

    } else { //CNPJ

        //Coloca ponto entre o segundo e o terceiro dÌgitos
        v=v.replace(/^(\d{2})(\d)/,"$1.$2")

        //Coloca ponto entre o quinto e o sexto dÌgitos
        v=v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3")

        //Coloca uma barra entre o oitavo e o nono dÌgitos
        v=v.replace(/\.(\d{3})(\d)/,".$1/$2")

        //Coloca um hÌfen depois do bloco de quatro dÌgitos
        v=v.replace(/(\d{4})(\d)/,"$1-$2")

    }

    return v

}

// version: beta
// created: 2005-08-30
// updated: 2005-08-31
// mredkj.com
function extractNumber(obj, decimalPlaces, allowNegative, forceDecimalPlaces)
{
	var temp = obj.value;
	
	// avoid changing things if already formatted correctly
	var reg0Str = '[0-9]*';
	if (decimalPlaces > 0) {
		reg0Str += '\\.?[0-9]{0,' + decimalPlaces + '}';
	} else if (decimalPlaces < 0) {
		reg0Str += '\\.?[0-9]*';
	}
	reg0Str = allowNegative ? '^-?' + reg0Str : '^' + reg0Str;
	reg0Str = reg0Str + '$';
	var reg0 = new RegExp(reg0Str);
	if (reg0.test(temp)){
		if(forceDecimalPlaces != undefined){
			if(temp.indexOf('.') == -1)
				obj.value = temp + '.00';
			else{
				for (i=0; i<(decimalPlaces - (temp.length - (temp.indexOf('.') + 1))); i++){
					temp += '0';
				}
				obj.value = temp;
			}
		}
		return true;
	}

	// first replace all non numbers
	var reg1Str = '[^0-9' + (decimalPlaces != 0 ? '.' : '') + (allowNegative ? '-' : '') + ']';
	var reg1 = new RegExp(reg1Str, 'g');
	temp = temp.replace(reg1, '');

	if (allowNegative) {
		// replace extra negative
		var hasNegative = temp.length > 0 && temp.charAt(0) == '-';
		var reg2 = /-/g;
		temp = temp.replace(reg2, '');
		if (hasNegative) temp = '-' + temp;
	}
	
	if (decimalPlaces != 0) {
		var reg3 = /\./g;
		var reg3Array = reg3.exec(temp);
		if (reg3Array != null) {
			// keep only first occurrence of .
			//  and the number of places specified by decimalPlaces or the entire string if decimalPlaces < 0
			var reg3Right = temp.substring(reg3Array.index + reg3Array[0].length);
			reg3Right = reg3Right.replace(reg3, '');
			reg3Right = decimalPlaces > 0 ? reg3Right.substring(0, decimalPlaces) : reg3Right;
			temp = temp.substring(0,reg3Array.index) + '.' + reg3Right;
		}
	}
	
	obj.value = temp;
}
function blockNonNumbers(obj, e, allowDecimal, allowNegative)
{
	var key;
	var isCtrl = false;
	var keychar;
	var reg;
		
	if(window.event) {
		key = e.keyCode;
		isCtrl = window.event.ctrlKey
	}
	else if(e.which) {
		key = e.which;
		isCtrl = e.ctrlKey;
	}
	
	if (isNaN(key)) return true;
	
	keychar = String.fromCharCode(key);
	
	// check for backspace or delete, or if Ctrl was pressed
	if (key == 8 || isCtrl)
	{
		return true;
	}

	reg = /\d/;
	var isFirstN = allowNegative ? keychar == '-' && obj.value.indexOf('-') == -1 : false;
	var isFirstD = allowDecimal ? keychar == '.' && obj.value.indexOf('.') == -1 : false;
	
	return isFirstN || isFirstD || reg.test(keychar);
}

function RetiraAcentos(Campo) {
   var Acentos = "·‡„‚‚¡¿√¬ÈÍ… ÌÕÛıÙ”‘’˙¸⁄‹Á«abcdefghijklmnopqrstuvxwyz";
   var Traducao ="AAAAAAAAAEEEEIIOOOOOOUUUUCCABCDEFGHIJKLMNOPQRSTUVXWYZ";
   var Posic, Carac;
   var TempLog = "";
   for (var i=0; i < Campo.length; i++)
   {
   Carac = Campo.charAt (i);
   Posic  = Acentos.indexOf (Carac);
   if (Posic > -1)
	  TempLog += Traducao.charAt (Posic);
   else
      TempLog += Campo.charAt (i);
   }
      return (TempLog);
}
