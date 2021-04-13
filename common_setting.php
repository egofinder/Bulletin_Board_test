<!--.................Main CSS file for Administrator Menu.........................-->
<link rel="stylesheet" type="text/css" href="./css/css.css">
<!--........................Calendar fuction javascript...........................-->
<script src="./js/DatePickerX.js"></script>
<!--........................Calendar initicate variable...........................-->
<script>
    window.addEventListener('DOMContentLoaded', function()
    {
        var $min = document.querySelector('.date [name="start_date"]'),
            $max = document.querySelector('.date [name="end_date"]');

        $min.DatePickerX.init({
            mondayFirst: true,
            minDate    : new Date(2016, 12, 1),
            maxDate    : $max
        });

        $max.DatePickerX.init({
            mondayFirst: true,
            minDate    : $min,
            //maxDate    : new Date(2017, 4, 25)
        });
    });

    window.addEventListener('DOMContentLoaded', function()
    {
        var $min = document.querySelector('.date [name="start_date1"]'),
            $max = document.querySelector('.date [name="end_date1"]');

        $min.DatePickerX.init({
            mondayFirst: true,
            minDate    : new Date(2016, 12, 1),
            maxDate    : $max
        });

        $max.DatePickerX.init({
            mondayFirst: true,
            minDate    : $min,
            //maxDate    : new Date(2017, 4, 25)
        });
    });


</script>

<?php 
$number_of_list = 50; //number of date displayed in one page. Only EVEN NUMBER WORKS
$page_number_limit = 10; //number of page qunatity.
$now_page = 1; //present page indicator to highlight current page.
?>