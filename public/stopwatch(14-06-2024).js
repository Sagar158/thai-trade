$(document).ready(function () {

    setTimeout(() => {

        var rowsForCountDown = document.querySelectorAll('tbody.main-table tr');

    console.log(rowsForCountDown);
    rowsForCountDown.forEach(function (row, index) {

        var startTime = row.querySelector('.dbttime');

        if (startTime != null) {
            var startTimeStr = startTime.textContent;
            if (startTimeStr.startsWith('Started:')) {

                var startTime = new Date(startTimeStr.replace('Started: ', ''));


                startCountdown(startTime, row);
            }
        }

    });


}, 2000);

    function startCountdown(startTime, row) {
        // console.log("yes 2")
        var countdownInterval = setInterval(function () {


            // var currentTime = new Date();
            var currentTime = serverTimeDate;
            var elapsedTime = currentTime - startTime;

            var days = Math.floor(elapsedTime / (1000 * 60 * 60 * 24));
            var hours = Math.floor((elapsedTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((elapsedTime % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((elapsedTime % (1000 * 60)) / 1000);
            var countdownString = days + "D " + hours.toString().padStart(2, '0') + ":" + minutes.toString().padStart(2, '0') + ":" + seconds.toString().padStart(2, '0');
            //  console.log(countdownString , row);
            row.querySelector('.dbttime').textContent = countdownString;

        }, 1000);
    }


});
