$(function(){
    if($("input").is("#calendar-field")) {
        Calendar.setup({
            inputField: "calendar-field",       // id of the input field
            ifFormat: "%Y-%m-%d %H:%M:%S",      // format of the input field
            button: "calendar-field",           // trigger for the calendar (button ID)
            align: "Br",                        // alignment
            timeFormat: "24",
            showsTime: true,
            singleClick: true
        });
    }
});