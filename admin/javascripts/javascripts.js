
/**
 * Change form action value required for submit form to another page 
 * 
 */
function changeaction(_ofm, _value) {    
    if (_value != '') {
	     _ofm.action = _value;
    }
}

/**
 * Open New Window
 * 
 */
function openWindow(page, wh) {
    day = new Date();
    handle = day.getTime();
    wh = arguments[1] ? arguments[1] : "width=600, height=500, ";
    window.open(page,handle, wh + "scrollbars=yes,resizable=1,status=0,toolbar=0,location=0,menubar=0");
    return false;
}

/**
 * select all element in a select box and submit form
 *
 * select box all values must be submit required for form
 *
 * @param formName string Formname
 * @param selectAll if true select all values, otherwise unselect
 * @see settings/menuorder
 */
function selectAll(formName,selectBox,selectAll) {
    // have we been passed an ID
    if (typeof selectBox == "string") {
        selectBox = document.getElementById(selectBox);
    }
    // is the select box a multiple select box?
    if (selectBox.type == "select-multiple") {
        for (var i = 0; i < selectBox.options.length; i++) {
            selectBox.options[i].selected = selectAll;
        }
    }
    document.forms[formName].submit();
}

