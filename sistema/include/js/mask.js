/*////////////////////////////////////////////////////////////////////////////////////////////////////////////////
|| Script language: JavaScript
|| Funcao para validacao de mascara pre-determinada
|| 
|| Ex:
|| <input type="text" onkeypress="mask(this,'000.000.000.000:000/00-00',1, event)">
|| Author: Leonardo Marchini Loureiro - Brazil
|| leonardo@loureiro.as
|| Modified: jun 19, 2009
||    -adicionada compatibilidade com firefox
||
|| this		= recebe o campo
|| formato	= formato da mascara
|| conteudo	= 1 - Só Numeros; 2 - Só Letras; 3 - Numeros e Letras; 4 - Alpha numerico(Qualquer caracter); 5 - Currency
*/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

var caracs = ['.', '/', '-', ':', '(', ')', ','];

function mask(campo, formato, conteudo, event) {
    var i, j;
    var auxPonto = formato;
    var auxBarra = formato;
    var auxHifen = formato;
    var auxDblPonto = formato;
    var auxAbrePar = formato;
    var auxFechaPar = formato;
    var auxVirgula = formato;
    var tamanho = formato.length;
    var posPonto = new Array(tamanho);
    var posBarra = new Array(tamanho);
    var posHifen = new Array(tamanho);
    var posDblPonto = new Array(tamanho);
    var posAbrePar = new Array(tamanho);
    var posFechaPar = new Array(tamanho);
    var posVirgula = new Array(tamanho);
    var keyPress = event;
    if (!event) keyPress = window.event;
    
    campo.maxLength = tamanho;

	if (keycode(keyPress) == Keys.TAB || keycode(keyPress) == Keys.ENTER) 
		return;

    if (keycode(keyPress) != Keys.BACKSPACE && keycode(keyPress) != Keys.DELETE && keycode(keyPress) != Keys.TAB) {
        switch (conteudo) {
            case 1: // Verifica se soh podem ser entrados valores numericos
                if (!(keycode(keyPress) >= 48 && keycode(keyPress) <= 57))
                    cancelEvent(keyPress);
                break;
            case 2: // Somente Letras
                if (!((keycode(keyPress) >= 97 && keycode(keyPress) <= 122) || (keycode(keyPress) >= 65 && keycode(keyPress) <= 90)))
                    cancelEvent(keyPress);
                break;
            case 3: // Letras e numeros
                if (!((keycode(keyPress) >= 48 && keycode(keyPress) <= 57) || (keycode(keyPress) >= 97 && keycode(keyPress) <= 122) || (keycode(keyPress) >= 65 && keycode(keyPress) <= 90)))
                    cancelEvent(keyPress);
                break;
            case 5: //Tratamento especial pra currency - so numeros
                if (!(keycode(keyPress) >= 48 && keycode(keyPress) <= 57))
                    cancelEvent(keyPress);
                else
                    FormataValor(campo, tamanho, event);
                return;
                break;
        }
    }


    // ---------------------------------------- PEGA A FORMATACAO DA MASCARA -----------------------------------
    for (i = 0; i < tamanho; i++) {

        posPonto[i] = auxPonto.indexOf('.');
        posBarra[i] = auxBarra.indexOf('/');
        posHifen[i] = auxHifen.indexOf('-');
        posDblPonto[i] = auxDblPonto.indexOf(':');
        posAbrePar[i] = auxAbrePar.indexOf('(');
        posFechaPar[i] = auxFechaPar.indexOf(')');
        posVirgula[i] = auxVirgula.indexOf(',');

        auxPonto = auxPonto.substring(posPonto[i] + 1, tamanho);
        auxBarra = auxBarra.substring(posBarra[i] + 1, tamanho);
        auxHifen = auxHifen.substring(posHifen[i] + 1, tamanho);
        auxDblPonto = auxDblPonto.substring(posDblPonto[i] + 1, tamanho);
        auxAbrePar = auxAbrePar.substring(posAbrePar[i] + 1, tamanho);
        auxFechaPar = auxFechaPar.substring(posFechaPar[i] + 1, tamanho);
        auxVirgula = auxVirgula.substring(posVirgula[i] + 1, tamanho);

        if (i > 0) {
            posPonto[i] = posPonto[i] + posPonto[i - 1];
            posBarra[i] = posBarra[i] + posBarra[i - 1];
            posHifen[i] = posHifen[i] + posHifen[i - 1];
            posDblPonto[i] = posDblPonto[i] + posDblPonto[i - 1];
            posAbrePar[i] = posAbrePar[i] + posAbrePar[i - 1];
            posFechaPar[i] = posFechaPar[i] + posFechaPar[i - 1];
            posVirgula[i] = posVirgula[i] + posVirgula[i - 1];

            posPonto[i] = posPonto[i] + 1;
            posBarra[i] = posBarra[i] + 1;
            posHifen[i] = posHifen[i] + 1;
            posDblPonto[i] = posDblPonto[i] + 1;
            posAbrePar[i] = posAbrePar[i] + 1;
            posFechaPar[i] = posFechaPar[i] + 1;
            posVirgula[i] = posVirgula[i] + 1;
        }

        /*
        alert('I ' + i +'\nAuxPonto		'+ auxPonto 	+' PosPonto		'+ posPonto[i]		+
        '\nAuxBarra		'+ auxBarra 	+' PosBarra		'+ posBarra[i]		+
        '\nAuxHifen		'+ auxHifen 	+' PosHifen		'+ posHifen[i]		+
        '\nAuxDblPonto	'+ auxDblPonto	+' PosDblPonto	'+ posDblPonto[i]	+
        '\nAuxAbrePar	'+ auxAbrePar	+' PosAbrePar	'+ posAbrePar[i]	+
        '\nAuxFechaPar	'+ auxFechaPar	+' PosFechaPar	'+ posFechaPar[i]	+
        '\nAuxVirgula	'+ auxVirgula	+' PosVirgula	'+ posVirgula[i]	);
        //*/

        // ---------------------------------------- APLICA A FORMATACAO DA MASCARA -----------------------------------
        tecla = keycode(keyPress);
        if (tecla != 8 && tecla != 45 && tecla != 46 && tecla != 47 && tecla != 58) {
            if (campo.value.length == posPonto[i]) {
                campo.value = campo.value + '.';
                campo.focus();
            }
            if (campo.value.length == posBarra[i]) {
                campo.value = campo.value + '/';
                campo.focus();
            }
            if (campo.value.length == posHifen[i]) {
                campo.value = campo.value + '-';
                campo.focus();
            }
            if (campo.value.length == posDblPonto[i]) {
                campo.value = campo.value + ':';
                campo.focus();
            }
            if (campo.value.length == posAbrePar[i]) {
                campo.value = campo.value + '(';
                campo.focus();
            }
            if (campo.value.length == posFechaPar[i]) {
                campo.value = campo.value + ')';
                campo.focus();
            }
            if (campo.value.length == posVirgula[i]) {
                campo.value = campo.value + ',';
                campo.focus();
            }

        }
    }
}

function keycode(keyPress) {
    if (!keyPress.keyCode)
        return keyPress.which;
    else
        return keyPress.keyCode;
}

function limpaMascara(str) {
    for (var i = 0; i < str.length; i++)
        for (var j = 0; j < caracs.length; j++)
        if (caracs[j] == str.charAt(i))
        str = str.replace(caracs[j], '');
    return str;
}

function FormataValor(campo, tammax, teclapres) {
    var tecla = teclapres.keyCode;
    if (tecla == 0) tecla = teclapres.which;
    vr = campo.value;
    vr = limpaMascara(vr)
    tam = vr.length;

    if (tam < tammax && tecla != 8) tam = vr.length + 1;

    if (tecla == 8) tam = tam - 1;

    if (tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105) {
        if (tam <= 2)
            campo.value = vr;

        if ((tam > 2) && (tam <= 5))
            campo.value = vr.substr(0, tam - 2) + ',' + vr.substr(tam - 2, tam);

        if ((tam >= 6) && (tam <= 8))
            campo.value = vr.substr(0, tam - 5) + '.' + vr.substr(tam - 5, 3) + ',' + vr.substr(tam - 2, tam);

        if ((tam >= 9) && (tam <= 11))
            campo.value = vr.substr(0, tam - 8) + '.' + vr.substr(tam - 8, 3) + '.' + vr.substr(tam - 5, 3) + ',' + vr.substr(tam - 2, tam);

        if ((tam >= 12) && (tam <= 14))
            campo.value = vr.substr(0, tam - 11) + '.' + vr.substr(tam - 11, 3) + '.' + vr.substr(tam - 8, 3) + '.' + vr.substr(tam - 5, 3) + ',' + vr.substr(tam - 2, tam);

        if ((tam >= 15) && (tam <= 17))
            campo.value = vr.substr(0, tam - 14) + '.' + vr.substr(tam - 14, 3) + '.' + vr.substr(tam - 11, 3) + '.' + vr.substr(tam - 8, 3) + '.' + vr.substr(tam - 5, 3) + ',' + vr.substr(tam - 2, tam);
    }

}

function isIE() {
    if (navigator.appName.toUpperCase() == 'MICROSOFT INTERNET EXPLORER')
        return true;
    else
        return false;
}


function cancelEvent(e) {
    if (!isIE())
        e.preventDefault()
    else
        e.keyCode = 0;
}




//////////////////////////////////

var Keys = {
    BACKSPACE: 8, TAB: 9, ENTER: 13, SHIFT: 16,
    CTRL: 17, ALT: 18, PAUSE: 19, CAPS: 20,
    ESC: 27, PAGEUP: 33, PAGEDN: 34, END: 35,
    HOME: 36, LEFT: 37, UP: 38, RIGHT: 39,
    DOWN: 40, INSERT: 45, DELETE: 46,
    n0: 48, n1: 49, n2: 50, n3: 51, n4: 52,
    n5: 53, n6: 54, n7: 55, n8: 56, n9: 57,
    A: 65, B: 66, C: 67, D: 68, E: 68, F: 70, G: 71, H: 72, I: 73, J: 74, K: 75,
    L: 76, M: 77, N: 78, O: 79, P: 80, Q: 81, R: 82, S: 83, T: 84, U: 85, V: 86,
    W: 87, X: 88, Y: 89, Z: 90,
    WINLEFT: 91, WINRIGHT: 92, SELECT: 93, NUM0: 96,
    NUM1: 97, NUM2: 98, NUM3: 99, NUM4: 100,
    NUM5: 101, NUM6: 102, NUM7: 103, NUM8: 104,
    NUM9: 105, MULTIPLY: 106, ADD: 107, SUBTRACT: 109,
    DECIMAL: 110, DIVIDE: 111, F1: 112, F2: 113,
    F3: 114, F4: 115, F5: 116, F6: 117,
    F7: 118, F8: 119, F9: 120, F10: 121,
    F11: 122, F12: 123, NUMLOCK: 144, SCROLLLOCK: 145,
    SEMICOLON: 186, EQUAL: 187, COMMA: 188, DASH: 189,
    PERIOD: 190, FORWARDSLASH: 191, GRAVEACCENT: 192,
    OPENBRACKET: 219, BACKSLASH: 220, CLOSEBRACKET: 221,
    QUOTE: 222
};

