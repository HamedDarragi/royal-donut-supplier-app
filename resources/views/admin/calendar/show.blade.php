@extends('admin.layout.app')
@section('css')
    <!-- file Uploads -->
    <link href="{{ asset('admin/assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!-- select2 Plugin -->
    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <style>
        textarea:hover {
            background-color: rgb(201, 199, 199)
        }

    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card m-b-20">
                <div class="card-body">
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')

    <script src="//cdn.ckeditor.com/4.16.0/standard/ckeditor.js">
    </script>

    <!--<script src='http://fullcalendar.io/js/fullcalendar-2.1.1/lib/moment.min.js'></script>-->
    <!--<script src='http://fullcalendar.io/js/fullcalendar-2.1.1/lib/jquery.min.js'></script>-->
    <!--<script src="http://fullcalendar.io/js/fullcalendar-2.1.1/lib/jquery-ui.custom.min.js"></script>-->
    <!--<script src='http://fullcalendar.io/js/fullcalendar-2.1.1/fullcalendar.min.js'></script>-->
    <script src='//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.0.1/fullcalendar.min.js'></script>
    <script src='//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.0.1/fullcalendar.min.css'></script>
    <script src='//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.0.1/fullcalendar.print.css'></script>
    <script>
        var check1 = <?php echo $check1; ?>;
        var check2 = <?php echo $check2; ?>;
        var datecheck = <?php echo $datecheck; ?>;



        $(document).ready(function() {
            var today = new Date();

            var date = $("#calendar").fullCalendar('getDate');
            date = moment(date).format('YYYY-MM-DD');
            year = sessionStorage.getItem("year");
            month = sessionStorage.getItem("month");
            if (!year) {
                year = moment(date).format('YYYY');
            }
            if (!month) {
                month = moment(date).format('MM');
            }

            var start = new Date(moment(date).format('YYYY-MM-DD'));
            // var year = today.getFullYear();
            // var month = today.getUTCMonth() + 1;
            if (month > 12) {
                month = 1;
                year++;
            }
            var start = new Date(year + '-' + month + '-01');
            var end = "";
            if (month == 1 || month == 3 || month == 5 || month == 7 || month == 8 || month == 10 || month == 12) {
                end = new Date(year + '-' + month + '-31');
            } else if (month == 2) {
                end = new Date(year + '-' + month + '-28');
            } else {
                end = new Date(year + '-' + month + '-30');
            }
            dayMilliseconds = 1000 * 60 * 60 * 24;

            var weekendDays = new Array();



            var calendar = $('#calendar').fullCalendar({
                defaultDate: start,
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                selectable: true,
                selectHelper: true,
                select: function(start, end, jsEvent, view) {
                    // var allDay = !start.hasTime() && !end.hasTime();
                    var selected_date = moment(start).format('YYYY-MM-DD');
                    // window.location.href = "/admin/candidate/exam/show/"+selected_date;
                    $.ajax('savedate', {
                        method: 'GET',
                        dataType: 'json', // type of response data
                        data: {
                            'date': selected_date,
                        },
                        success: function(data) { // success callback function
                            // new code======================
                            //  window.location.href = "/calendar";
                            location.reload();
                            //==================================
                        },
                        error: function(data) { // error callback
                            var errors = data.responseJSON;

                        }
                    });


                },
            });



            myEvent = new Array();
            var myCalendar = $('#calendar');
            var i = 0;

            myCalendar.fullCalendar();
            while (start <= end) {
                var day = start.getDay();
                var selected_date = moment(start).format('YYYY-MM-DD');
                if (day == 0 || day == 6) {

                    if (datecheck.includes(selected_date)) {
                        if (check1[selected_date] == 0) {
                            var myevent = {
                                title: "Holiday",
                                allDay: true,
                                start: selected_date,
                                end: selected_date,
                                color: 'red'

                            };

                            myEvent.push(selected_date);
                            myCalendar.fullCalendar('renderEvent', myevent);
                        } else {
                            var myevent = {
                                title: "Working Day",
                                allDay: true,
                                start: selected_date,
                                end: selected_date,
                                color: 'green'

                            };

                            myEvent.push(selected_date);
                            myCalendar.fullCalendar('renderEvent', myevent);
                        }


                    } else {

                        var myevent = {
                            title: "Holiday",
                            allDay: true,
                            start: selected_date,
                            end: selected_date,
                            color: 'red'

                        };

                        myEvent.push(selected_date);
                        myCalendar.fullCalendar('renderEvent', myevent);

                    }

                } else {



                    if (datecheck.includes(selected_date)) {
                        if (check1[selected_date] == 0) {
                            var myevent = {
                                title: "Holiday",
                                allDay: true,
                                start: selected_date,
                                end: selected_date,
                                color: 'red'

                            };

                            myEvent.push(selected_date);
                            myCalendar.fullCalendar('renderEvent', myevent);
                        } else {
                            var myevent = {
                                title: "Working Day",
                                allDay: true,
                                start: selected_date,
                                end: selected_date,
                                color: 'green'

                            };

                            myEvent.push(selected_date);
                            myCalendar.fullCalendar('renderEvent', myevent);
                        }


                    } else {

                        var myevent = {
                            title: "Working Day",
                            allDay: true,
                            start: selected_date,
                            end: selected_date,
                            color: 'green'

                        };

                        myCalendar.fullCalendar('renderEvent', myevent);
                    }


                }
                start.setUTCDate(start.getUTCDate() + 1);
                i++;

            }

            $(".fc-next-button").on('click', function() {
                nextPrevious();
            });


            // PREVIOUS FUNCTION

            $(".fc-prev-button").on('click', function() {
                nextPrevious();
            });

            $(".fc-today-button").on('click', function() {
                todayDate();
            });

            function nextPrevious() {
                var today = new Date();


                var date = $("#calendar").fullCalendar('getDate');
                date = moment(date).format('YYYY-MM-DD');
                year = moment(date).format('YYYY');
                month = moment(date).format('MM');

                sessionStorage.removeItem('year');
                sessionStorage.removeItem('month');

                sessionStorage.setItem("year", year);
                sessionStorage.setItem("month", month);


                var start = new Date(moment(date).format('YYYY-MM-DD'));
                var end = '';
                if (month == 1 || month == 3 || month == 5 || month == 7 || month == 8 || month == 10 || month ==
                    12) {
                    end = new Date(year + '-' + month + '-31');
                } else if (month == 2) {
                    end = new Date(year + '-' + month + '-28');
                } else {
                    end = new Date(year + '-' + month + '-30');
                }


                dayMilliseconds = 1000 * 60 * 60 * 24;

                var weekendDays = new Array();



                var calendar = $('#calendar').fullCalendar({
                    defaultDate: start,
                    editable: true,
                    eventLimit: true, // allow "more" link when too many events
                    selectable: true,
                    selectHelper: true,
                    select: function(start, end, jsEvent, view) {
                        // var allDay = !start.hasTime() && !end.hasTime();
                        var selected_date = moment(start).format('YYYY-MM-DD');
                        // window.location.href = "/admin/candidate/exam/show/"+selected_date;


                    },
                });



                myEvent = new Array();
                var myCalendar = $('#calendar');
                var i = 1;
                myCalendar.fullCalendar();
                while (start <= end) {
                    var day = start.getDay();
                    var selected_date = moment(start).format('YYYY-MM-DD');
                    if (day == 0 || day == 6) {

                        if (datecheck.includes(selected_date)) {
                            if (check1[selected_date] == 0) {
                                var myevent = {
                                    title: "Holiday",
                                    allDay: true,
                                    start: selected_date,
                                    end: selected_date,
                                    color: 'red'

                                };

                                myEvent.push(selected_date);
                                myCalendar.fullCalendar('renderEvent', myevent);
                            } else {
                                var myevent = {
                                    title: "Working Day",
                                    allDay: true,
                                    start: selected_date,
                                    end: selected_date,
                                    color: 'green'

                                };

                                myEvent.push(selected_date);
                                myCalendar.fullCalendar('renderEvent', myevent);
                            }


                        } else {

                            var myevent = {
                                title: "Holiday",
                                allDay: true,
                                start: selected_date,
                                end: selected_date,
                                color: 'red'

                            };

                            myEvent.push(selected_date);
                            myCalendar.fullCalendar('renderEvent', myevent);

                        }

                    } else {



                        if (datecheck.includes(selected_date)) {
                            if (check1[selected_date] == 0) {
                                var myevent = {
                                    title: "Holiday",
                                    allDay: true,
                                    start: selected_date,
                                    end: selected_date,
                                    color: 'red'

                                };

                                myEvent.push(selected_date);
                                myCalendar.fullCalendar('renderEvent', myevent);
                            } else {
                                var myevent = {
                                    title: "Working Day",
                                    allDay: true,
                                    start: selected_date,
                                    end: selected_date,
                                    color: 'green'

                                };

                                myEvent.push(selected_date);
                                myCalendar.fullCalendar('renderEvent', myevent);
                            }


                        } else {

                            var myevent = {
                                title: "Working Day",
                                allDay: true,
                                start: selected_date,
                                end: selected_date,
                                color: 'green'

                            };

                            myCalendar.fullCalendar('renderEvent', myevent);
                        }


                    }
                    start.setUTCDate(start.getUTCDate() + 1);
                    i++;

                }

            }



            // Today


            function todayDate() {
                var date = new Date();


                // var date = $("#calendar").fullCalendar('getDate');
                date = moment(date).format('YYYY-MM-DD');
                year = moment(date).format('YYYY');
                month = moment(date).format('MM');

                sessionStorage.removeItem('year');
                sessionStorage.removeItem('month');

                sessionStorage.setItem("year", year);
                sessionStorage.setItem("month", month);


                var start = new Date(year + '-' + month + '-01');

                console.log(start)

                var end = '';
                if (month == 1 || month == 3 || month == 5 || month == 7 || month == 8 || month == 10 || month ==
                    12) {
                    end = new Date(year + '-' + month + '-31');
                } else if (month == 2) {
                    end = new Date(year + '-' + month + '-28');
                } else {
                    end = new Date(year + '-' + month + '-30');
                }


                dayMilliseconds = 1000 * 60 * 60 * 24;

                var weekendDays = new Array();



                var calendar = $('#calendar').fullCalendar({
                    defaultDate: start,
                    editable: true,
                    eventLimit: true, // allow "more" link when too many events
                    selectable: true,
                    selectHelper: true,
                    select: function(start, end, jsEvent, view) {
                        // var allDay = !start.hasTime() && !end.hasTime();
                        var selected_date = moment(start).format('YYYY-MM-DD');
                        // window.location.href = "/admin/candidate/exam/show/"+selected_date;


                    },
                });



                myEvent = new Array();
                var myCalendar = $('#calendar');
                var i = 1;
                myCalendar.fullCalendar();
                while (start <= end) {
                    var day = start.getDay();
                    var selected_date = moment(start).format('YYYY-MM-DD');
                    if (day == 0 || day == 6) {

                        if (datecheck.includes(selected_date)) {
                            if (check1[selected_date] == 0) {
                                var myevent = {
                                    title: "Holiday",
                                    allDay: true,
                                    start: selected_date,
                                    end: selected_date,
                                    color: 'red'

                                };

                                myEvent.push(selected_date);
                                myCalendar.fullCalendar('renderEvent', myevent);
                            } else {
                                var myevent = {
                                    title: "Working Day",
                                    allDay: true,
                                    start: selected_date,
                                    end: selected_date,
                                    color: 'green'

                                };

                                myEvent.push(selected_date);
                                myCalendar.fullCalendar('renderEvent', myevent);
                            }


                        } else {

                            var myevent = {
                                title: "Holiday",
                                allDay: true,
                                start: selected_date,
                                end: selected_date,
                                color: 'red'

                            };

                            myEvent.push(selected_date);
                            myCalendar.fullCalendar('renderEvent', myevent);

                        }

                    } else {



                        if (datecheck.includes(selected_date)) {
                            if (check1[selected_date] == 0) {
                                var myevent = {
                                    title: "Holiday",
                                    allDay: true,
                                    start: selected_date,
                                    end: selected_date,
                                    color: 'red'

                                };

                                myEvent.push(selected_date);
                                myCalendar.fullCalendar('renderEvent', myevent);
                            } else {
                                var myevent = {
                                    title: "Working Day",
                                    allDay: true,
                                    start: selected_date,
                                    end: selected_date,
                                    color: 'green'

                                };

                                myEvent.push(selected_date);
                                myCalendar.fullCalendar('renderEvent', myevent);
                            }


                        } else {

                            var myevent = {
                                title: "Working Day",
                                allDay: true,
                                start: selected_date,
                                end: selected_date,
                                color: 'green'

                            };

                            myCalendar.fullCalendar('renderEvent', myevent);
                        }


                    }
                    start.setUTCDate(start.getUTCDate() + 1);
                    i++;

                }

            }

        });
    </script>

    @isset($product)
        <script>
            $('.categories').val({!! json_encode($product->id) !!}).trigger('change');
        </script>
    @endisset
    <!-- Inline js -->
    <script src="{{ asset('admin/assets/js/formelements.js') }}"></script>

    <!-- file uploads js -->
    <script src="{{ asset('admin/assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <!-- select2 Plugin -->
    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endsection
