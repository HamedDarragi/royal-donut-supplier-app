@extends('delivery_partial.layout.app')
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card m-b-20">
                <div class="card-header">
                    <h3 class="card-title">Delivery Demo</h3>
                </div>
                <div class="card-body">
                    {{ csrf_field() }}
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">
                                <strong>Danger!</strong> {{ $error }}
                            </div>
                        @endforeach
                    @endif
                    <div class="form-group">
                        <label>Delivery Date</label>
                        <input type="date" name="delivery_day" id="delivery_day" required class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Rule</label>
                        <select name="rule" class="form-control" id="rule_select">
                            <option disabled selected>Select Rule</option>
                            @foreach ($rule as $rule_item)
                                <option value={{ $rule_item->id }}>{{ $rule_item->name }} Where Acceptance Time
                                    {{ $rule_item->acceptance_time }} And Delivery Days are
                                    {{ $rule_item->delivery_days }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="btn" class="btn btn-primary" id="working_day">Is Working Day</button>
                    <button type="btn" class="btn btn-primary" id="delivery_day_btn">Is Delivery Day</button>
                    <button type="btn" class="btn btn-primary" id="delivery_date">Delivery Date</button>
                </div>
            </div>
        </div>
    </div>
@section('script')
    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <script>
        $('#working_day').on('click', function() {
            var last_date_data_element = null;

            var rule_data = null;

            var d = new Date();
            var getTot = daysInMonth(d.getMonth(), d.getFullYear());
            // console.log(daysInMonth(d.getMonth(), d.getFullYear()))
            var sat = new Array();
            var sun = new Array();

            for (var i = 1; i <= getTot; i++) {
                var newDate = new Date(d.getFullYear(), d.getMonth(), i)
                // console.log(i + "-" + newDate.getDay());
                if (newDate.getDay() == 0) {
                    sun.push(moment(newDate).format("YYYY-MM-DD"));
                }
                if (newDate.getDay() == 6) {
                    sat.push(moment(newDate).format("YYYY-MM-DD"));
                }

            }

            function daysInMonth(month, year) {
                return new Date(year, month, 0).getDate();
            }
            var last_date_data_element = null;

            var rule_data = null;

            var d = new Date();
            var getTot = daysInMonth(d.getMonth(), d.getFullYear());
            // console.log(daysInMonth(d.getMonth(), d.getFullYear()))
            var sat = new Array();
            var sun = new Array();

            for (var i = 1; i <= getTot; i++) {
                var newDate = new Date(d.getFullYear(), d.getMonth(), i)
                // console.log(i + "-" + newDate.getDay());
                if (newDate.getDay() == 0) {
                    sun.push(moment(newDate).format("YYYY-MM-DD"));
                }
                if (newDate.getDay() == 6) {
                    sat.push(moment(newDate).format("YYYY-MM-DD"));
                }

            }

            function daysInMonth(month, year) {
                return new Date(year, month, 0).getDate();
            }

            $.ajax({
                type: "POST",
                url: 'get_rule_delivery',
                async: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    rule_id: $('#rule_select').val(),
                    delivery_day: $('#delivery_day').val(),
                },
                success: function(response) {
                    rule_data = response;
                    var selected_days = rule_data.delivery_days.split(",");

                    var date_increment = 0;
                    // for (var i = 0; i <= parseInt(rule_data.treatment_time); i++) {

                    //     for (var j = 0; j < 7; j++) {
                    var select_new_date = $('#delivery_day').val();
                    var new_date = new Date(select_new_date);
                    // console.log("NEW DATEEEE", new_date);
                    var selected_days = rule_data.delivery_days.split(",");
                    var get_hour = new_date.getHours();
                    var get_minute = new_date.getMinutes();
                    var time = get_hour + ":" + get_minute;
                    // new_date.setDate(new_date.getDate() + date_increment);
                    var day_in_words = new_date.toLocaleString('en-us', {
                        weekday: 'long'
                    });
                    var day_format_ymd = moment(new_date).format("YYYY-MM-DD");
                    $.ajax({
                        url: 'check_db',
                        type: "POST",
                        async: false,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            date: day_format_ymd,
                        },
                        success: function(response) {
                            if (response.db == true) {
                                if (response.data.status == 1) {
                                    alert("Yes, It is working day : " + response
                                        .data.c_date);
                                } else {
                                    alert("No It is a Holiday");
                                }
                            } else {
                                if (!sat.includes(response.data) && !sun
                                    .includes(
                                        response.data)) {
                                    alert("Yes, It is working day : " + response
                                        .data);
                                } else {
                                    alert("No It is a Holiday");
                                }
                            }
                        }
                    });
                    // date_increment++;
                    //     }
                    // }
                }
            });
        });
        $('#delivery_day_btn').on('click', function() {
            console.log("CLICKED");
            var last_date_data_element = null;

            var rule_data = null;

            var d = new Date();
            var getTot = daysInMonth(d.getMonth(), d.getFullYear());
            // console.log(daysInMonth(d.getMonth(), d.getFullYear()))
            var sat = new Array();
            var sun = new Array();

            for (var i = 1; i <= getTot; i++) {
                var newDate = new Date(d.getFullYear(), d.getMonth(), i)
                // console.log(i + "-" + newDate.getDay());
                if (newDate.getDay() == 0) {
                    sun.push(moment(newDate).format("YYYY-MM-DD"));
                }
                if (newDate.getDay() == 6) {
                    sat.push(moment(newDate).format("YYYY-MM-DD"));
                }

            }

            function daysInMonth(month, year) {
                return new Date(year, month, 0).getDate();
            }
            var last_date_data_element = null;

            var rule_data = null;

            var d = new Date();
            var getTot = daysInMonth(d.getMonth(), d.getFullYear());
            // console.log(daysInMonth(d.getMonth(), d.getFullYear()))
            var sat = new Array();
            var sun = new Array();

            for (var i = 1; i <= getTot; i++) {
                var newDate = new Date(d.getFullYear(), d.getMonth(), i)
                // console.log(i + "-" + newDate.getDay());
                if (newDate.getDay() == 0) {
                    sun.push(moment(newDate).format("YYYY-MM-DD"));
                }
                if (newDate.getDay() == 6) {
                    sat.push(moment(newDate).format("YYYY-MM-DD"));
                }

            }

            function daysInMonth(month, year) {
                return new Date(year, month, 0).getDate();
            }

            $.ajax({
                type: "POST",
                url: 'get_rule_delivery',
                async: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    rule_id: $('#rule_select').val(),
                    delivery_day: $('#delivery_day').val(),
                },
                success: function(response) {
                    rule_data = response;
                    var selected_days = rule_data.delivery_days.split(",");
                    console.log("RULEE", rule_data);
                    var date_increment = 0;
                    // for (var i = 0; i <= parseInt(rule_data.treatment_time); i++) {

                    // for (var j = 0; j < 7; j++) {
                    var select_new_date = $('#delivery_day').val();
                    var new_date = new Date(select_new_date);
                    // console.log("NEW DATEEEE", new_date);
                    var selected_days = rule_data.delivery_days.split(",");
                    var get_hour = new_date.getHours();
                    var get_minute = new_date.getMinutes();
                    var time = get_hour + ":" + get_minute;
                    // new_date.setDate(new_date.getDate());
                    var day_in_words = new_date.toLocaleString('en-us', {
                        weekday: 'long'
                    });
                    var day_format_ymd = moment(new_date).format("YYYY-MM-DD");
                    $.ajax({
                        url: 'check_db',
                        type: "POST",
                        async: false,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            date: day_format_ymd,
                        },
                        success: function(response) {
                            console.log("RESSSSSSS", response);
                            if (response.db == true) {
                                if (response.data.status == 1) {
                                    console.log("SELECTED DAYS 111", selected_days);
                                    console.log("DAY IN WORDSSS 111", day_in_words);
                                    if (selected_days.includes(
                                            day_in_words)) {
                                        alert("Yes, It is delivery day : " +
                                            response.data.c_date);
                                    } else {
                                        alert("No It is not a delivery date");
                                    }
                                } else {
                                    alert(
                                        "No, it is holiday, so it can't be a delivery day");
                                }
                            } else {
                                if (!sat.includes(response.data) && !sun
                                    .includes(
                                        response.data)) {
                                    console.log("SELECTED DAYS", selected_days);
                                    console.log("DAY IN WORDSSS", day_in_words);
                                    if (selected_days.includes(
                                            day_in_words)) {
                                        alert("Yes, It is delivery day : " +
                                            response
                                            .data);
                                    } else {
                                        alert("No It is not a delivery day");
                                    }
                                }


                            }
                        }
                    });
                    //     date_increment++;
                    // }
                    // }
                }
            });
        });
        $('#delivery_date').on('click', function() {
            console.log("DAY", $('#delivery_day').val());
            console.log("RULE", $('#rule_select').val());
            var last_date_data_element = null;

            var rule_data = null;

            var d = new Date();
            var getTot = daysInMonth(d.getMonth(), d.getFullYear());
            // console.log(daysInMonth(d.getMonth(), d.getFullYear()))
            var sat = new Array();
            var sun = new Array();

            for (var i = 1; i <= getTot; i++) {
                var newDate = new Date(d.getFullYear(), d.getMonth(), i)
                // console.log(i + "-" + newDate.getDay());
                if (newDate.getDay() == 0) {
                    sun.push(moment(newDate).format("YYYY-MM-DD"));
                }
                if (newDate.getDay() == 6) {
                    sat.push(moment(newDate).format("YYYY-MM-DD"));
                }

            }

            function daysInMonth(month, year) {
                return new Date(year, month, 0).getDate();
            }
            var date_data_array = [];
            var next_delivery_date = null;
            $.ajax({
                type: "POST",
                url: 'get_rule_delivery',
                async: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    rule_id: $('#rule_select').val(),
                    delivery_day: $('#delivery_day').val(),
                },
                success: function(response) {
                    rule_data = response;
                    console.log("Ressssssss", response);
                    var selected_days = rule_data.delivery_days.split(",");

                    var date_increment = 0;
                    for (var i = 0; i <= parseInt(rule_data.treatment_time); i++) {

                        for (var j = 0; j < 7; j++) {
                            var select_new_date = $('#delivery_day').val();
                            var new_date = new Date(select_new_date);
                            // console.log("NEW DATEEEE", new_date);
                            var selected_days = rule_data.delivery_days.split(",");
                            var get_hour = new_date.getHours();
                            var get_minute = new_date.getMinutes();
                            var time = get_hour + ":" + get_minute;
                            new_date.setDate(new_date.getDate() + date_increment);
                            var day_in_words = new_date.toLocaleString('en-us', {
                                weekday: 'long'
                            });
                            // console.log("DDDDDDDDDD", day_in_words);
                            // console.log("SELECT", selected_days.includes(day_in_words));
                            // if (selected_days.includes(day_in_words)) {
                            var day_format_ymd = moment(new_date).format("YYYY-MM-DD");
                            // console.log("DYYYY", day_format_ymd);
                            $.ajax({
                                url: 'check_db',
                                type: "POST",
                                async: false,
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    date: day_format_ymd,
                                },
                                success: function(response) {
                                    // console.log("RESSSSS DBBBBB", response);
                                    if (response.db == true) {
                                        console.log("INSIDE DB", response);
                                        if (response.data.status == 1) {
                                            // console.log("INSIDE STATUS", parseFloat(
                                            // time));
                                            console.log("DATE DATA ARRAY", date_data_array
                                                .length);
                                            // if (parseFloat(time) <= parseFloat(
                                            //         rule_data.acceptance_time)) {
                                            if (date_data_array.length <
                                                parseInt(
                                                    rule_data.treatment_time)) {

                                                date_data_array.push(response
                                                    .data.c_date);
                                            } else {
                                                if (selected_days.includes(day_in_words)) {
                                                    if (next_delivery_date == null) {
                                                        next_delivery_date = response
                                                            .data.c_date;
                                                    }

                                                }
                                            }
                                            // } else {
                                            //     if (date_data_array.length <=
                                            //         parseInt(parseInt(rule_data
                                            //             .treatment_time) + 1)) {

                                            //         date_data_array.push(
                                            //             response.data.c_date);
                                            //     }
                                            // }
                                        }
                                    } else {
                                        // console.log("RESSSSSSSSS", response
                                        //     .data);
                                        // console.log("SATTTT INCCCCCCC", !sat
                                        //     .includes(day_format_ymd));
                                        // console.log("SUNN INCCCCCCCCC", !sun
                                        //     .includes(day_format_ymd))
                                        if (!sat.includes(response.data) && !sun
                                            .includes(
                                                response.data)) {
                                            console.log("RESSSSSSSS DATEEEEEEEE", response
                                                .data);
                                            // if (parseFloat(time) <= parseFloat(
                                            //         rule_data.acceptance_time)) {
                                            console.log("DATE DATA ARRAY", date_data_array
                                                .length);
                                            if (date_data_array.length <
                                                parseInt(
                                                    rule_data.treatment_time)) {

                                                date_data_array.push(response
                                                    .data);
                                            } else {
                                                console.log("SELECTED DAYS", selected_days);
                                                console.log("DAY IN WORDS", day_in_words);
                                                console.log("DATEEEEEEEE", response.data);
                                                if (selected_days.includes(day_in_words)) {
                                                    if (next_delivery_date == null) {
                                                        next_delivery_date = response.data;
                                                    }

                                                }
                                            }
                                            // } else {
                                            //     if (date_data_array.length <=
                                            //         parseInt(parseInt(rule_data
                                            //             .treatment_time) + 1)) {

                                            //         date_data_array.push(
                                            //             response.data);
                                            //     }
                                            // }
                                        }
                                    }


                                }
                            });
                            // }
                            date_increment++;
                        }
                    }
                    // $('#loading').css('display', 'none');
                    // $('#modal_body').css('display', 'block');
                    // $('#delivery_day').html("Your Order Will be ");
                    console.log("DATE DATAAAAAAAA",
                        date_data_array);
                    console.log("DELIVERY", next_delivery_date);
                    last_date_data_element = date_data_array.at(-1);
                    alert("The Calculated Delivery Date of the scenario is " + next_delivery_date);


                }
            });
        });
        $('#formData').submit(function(e) {
            e.preventDefault();
            console.log("DAY", $('#delivery_day').val());
            console.log("RULE", $('#rule_select').val());
            var last_date_data_element = null;

            var rule_data = null;

            var d = new Date();
            var getTot = daysInMonth(d.getMonth(), d.getFullYear());
            // console.log(daysInMonth(d.getMonth(), d.getFullYear()))
            var sat = new Array();
            var sun = new Array();

            for (var i = 1; i <= getTot; i++) {
                var newDate = new Date(d.getFullYear(), d.getMonth(), i)
                // console.log(i + "-" + newDate.getDay());
                if (newDate.getDay() == 0) {
                    sun.push(moment(newDate).format("YYYY-MM-DD"));
                }
                if (newDate.getDay() == 6) {
                    sat.push(moment(newDate).format("YYYY-MM-DD"));
                }

            }

            function daysInMonth(month, year) {
                return new Date(year, month, 0).getDate();
            }
            var date_data_array = [];
            var next_delivery_date = null;
            $.ajax({
                type: "POST",
                url: 'get_rule_delivery',
                async: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    rule_id: $('#rule_select').val(),
                    delivery_day: $('#delivery_day').val(),
                },
                success: function(response) {
                    rule_data = response;
                    console.log("Ressssssss", response);
                    var selected_days = rule_data.delivery_days.split(",");

                    var date_increment = 0;
                    for (var i = 0; i <= parseInt(rule_data.treatment_time); i++) {

                        for (var j = 0; j < 7; j++) {
                            var select_new_date = $('#delivery_day').val();
                            var new_date = new Date(select_new_date);
                            // console.log("NEW DATEEEE", new_date);
                            var selected_days = rule_data.delivery_days.split(",");
                            var get_hour = new_date.getHours();
                            var get_minute = new_date.getMinutes();
                            var time = get_hour + ":" + get_minute;
                            new_date.setDate(new_date.getDate() + date_increment);
                            var day_in_words = new_date.toLocaleString('en-us', {
                                weekday: 'long'
                            });
                            // console.log("DDDDDDDDDD", day_in_words);
                            // console.log("SELECT", selected_days.includes(day_in_words));
                            // if (selected_days.includes(day_in_words)) {
                            var day_format_ymd = moment(new_date).format("YYYY-MM-DD");
                            // console.log("DYYYY", day_format_ymd);
                            $.ajax({
                                url: 'check_db',
                                type: "POST",
                                async: false,
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    date: day_format_ymd,
                                },
                                success: function(response) {
                                    // console.log("RESSSSS DBBBBB", response);
                                    if (response.db == true) {
                                        console.log("INSIDE DB", response);
                                        if (response.data.status == 1) {
                                            // console.log("INSIDE STATUS", parseFloat(
                                            // time));
                                            console.log("DATE DATA ARRAY",
                                                date_data_array
                                                .length);
                                            // if (parseFloat(time) <= parseFloat(
                                            //         rule_data.acceptance_time)) {
                                            if (date_data_array.length <
                                                parseInt(
                                                    rule_data.treatment_time
                                                )) {

                                                date_data_array.push(
                                                    response
                                                    .data.c_date);
                                            } else {
                                                if (selected_days.includes(
                                                        day_in_words)) {
                                                    if (next_delivery_date ==
                                                        null) {
                                                        next_delivery_date =
                                                            response
                                                            .data.c_date;
                                                    }

                                                }
                                            }
                                            // } else {
                                            //     if (date_data_array.length <=
                                            //         parseInt(parseInt(rule_data
                                            //             .treatment_time) + 1)) {

                                            //         date_data_array.push(
                                            //             response.data.c_date);
                                            //     }
                                            // }
                                        }
                                    } else {
                                        // console.log("RESSSSSSSSS", response
                                        //     .data);
                                        // console.log("SATTTT INCCCCCCC", !sat
                                        //     .includes(day_format_ymd));
                                        // console.log("SUNN INCCCCCCCCC", !sun
                                        //     .includes(day_format_ymd))
                                        if (!sat.includes(response.data) &&
                                            !sun
                                            .includes(
                                                response.data)) {
                                            console.log(
                                                "RESSSSSSSS DATEEEEEEEE",
                                                response
                                                .data);
                                            // if (parseFloat(time) <= parseFloat(
                                            //         rule_data.acceptance_time)) {
                                            console.log("DATE DATA ARRAY",
                                                date_data_array
                                                .length);
                                            if (date_data_array.length <
                                                parseInt(
                                                    rule_data.treatment_time
                                                )) {

                                                date_data_array.push(
                                                    response
                                                    .data);
                                            } else {
                                                console.log("SELECTED DAYS",
                                                    selected_days);
                                                console.log("DAY IN WORDS",
                                                    day_in_words);
                                                console.log("DATEEEEEEEE",
                                                    response
                                                    .data);
                                                if (selected_days.includes(
                                                        day_in_words)) {
                                                    if (next_delivery_date ==
                                                        null) {
                                                        next_delivery_date =
                                                            response
                                                            .data;
                                                    }

                                                }
                                            }
                                            // } else {
                                            //     if (date_data_array.length <=
                                            //         parseInt(parseInt(rule_data
                                            //             .treatment_time) + 1)) {

                                            //         date_data_array.push(
                                            //             response.data);
                                            //     }
                                            // }
                                        }
                                    }


                                }
                            });
                            // }
                            date_increment++;
                        }
                    }
                    // $('#loading').css('display', 'none');
                    // $('#modal_body').css('display', 'block');
                    // $('#delivery_day').html("Your Order Will be ");
                    console.log("DATE DATAAAAAAAA",
                        date_data_array);
                    console.log("DELIVERY", next_delivery_date);
                    last_date_data_element = date_data_array.at(-1);


                }
            });
        });
    </script>
@endsection
@endsection
