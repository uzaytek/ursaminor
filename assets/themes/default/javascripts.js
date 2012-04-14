// open new window 
function openWindow(page, wh) {
    day = new Date();
    handle = day.getTime();
    wh = arguments[1] ? arguments[1] : "width=800, height=600, ";
    window.open(page,handle, wh + "scrollbars=yes,resizable=1,status=0,toolbar=0,location=0,menubar=0");
    return false;
}
