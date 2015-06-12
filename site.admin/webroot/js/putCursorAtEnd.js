function putCursorAtEnd(elem)
{

    elem.focus();
    elem.setSelectionRange(elem.value.length, elem.value.length);

    // Trigger a "space" keypress.
    var evt = document.createEvent("KeyboardEvent");
    evt.initKeyEvent("keypress", true, true, null, false, false, false, false, 0, 32);
    elem.dispatchEvent(evt);

    // Trigger a "backspace" keypress.
    evt = document.createEvent("KeyboardEvent");
    evt.initKeyEvent("keypress", true, true, null, false, false, false, false, 8, 0);
    elem.dispatchEvent(evt);
}
