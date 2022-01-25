<link rel="stylesheet" type="text/css" href="<?= assets_url() ?>app-assets/vendors/css/calendars/fullcalendar.min.css?v=<?= APPVER ?>">
<link href="<?php echo assets_url(); ?>assets/c_portcss/bootstrapValidator.min.css?v=<?= APPVER ?>" rel="stylesheet" />
<link href="<?php echo assets_url(); ?>assets/c_portcss/bootstrap-colorpicker.min.css?v=<?= APPVER ?>" rel="stylesheet" />
<!-- Custom css  -->
<link href="<?php echo assets_url(); ?>assets/c_portcss/custom.css?v=<?= APPVER ?>" rel="stylesheet" />

<script src='<?php echo assets_url(); ?>assets/c_portjs/bootstrap-colorpicker.min.js?v=<?= APPVER ?>'></script>


<div class="content-body">
    <div class="card">

        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card-body">

                <!-- Notification -->
                <div class="alert"></div>


                <div id='calendar'></div>

            </div>
        </div>
    </div>
</div>


<div class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                <div class="error"></div>
                <form class="form-horizontal" id="crud-form">
                    <input type="hidden" id="start">
                    <input type="hidden" id="end">
                    <div class="row form-group">
                        <label class="col-md-4 control-label" for="title">Add Appointment</label>

                    </div>
                    <div class="row form-group">
                        <label class="col-md-4 control-label" for="title"><?php echo $this->lang->line('Title') ?></label>
                        <div class="col-md-8">
                            <input id="titleShow" name="titleShow" type="hidden" class="form-control input-md" />
                            <input id="title" name="title" type="text" class="form-control input-md" />
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-4 control-label" for="userid">User(employee)</label>
                        <div class="col-md-8">
                            <select name="userid" id="userid" class="form-control input-md">
                                <?php
                                foreach ($employee as $row) {
                                    $serviceIds = $row['service'];
                                    $cid = $row['id'];
                                    $acn = $row['name'];
                                    echo "<option value='$cid' data-serviceid = '[$serviceIds]'>$acn</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-4 control-label" for="userid">Service</label>
                        <div class="col-md-8">
                            <select name="service_id" id="service_id" class="form-control input-md">
                                <?php
                                foreach ($services as $row) {
                                    $cid = $row['id'];
                                    $acn = $row['name'];
                                    $timeEst = $row['settime'];
                                    echo "<option value='$cid' data-servicetime=$timeEst>$acn</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-4 control-label" for="datetime">Date Time start</label>
                        <div class="col-md-8">
                            <input id="datetime" name="datetime" type="datetime-local" class="form-control input-md" />
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-4 control-label" for="datetimeend">Date Time end</label>
                        <div class="col-md-8">
                            <input id="datetimeend" name="datetimeend" type="datetime-local" class="form-control input-md" />
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-4 control-label" for="customerid">Customer</label>
                        <div class="col-md-8">
                            <select name="customerid" id="customerid" class="form-control select-box" style="width: 100%">
                                <option value="">--انتخاب کنید--</option>
                                <?php
                                foreach ($customers as $row) {
                                    $cid = $row->id;
                                    $acn = $row->name;
                                    echo "<option value='$cid'>$acn</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>


                    <div class="row form-group">
                        <label class="col-md-4 control-label" for="description"><?php echo $this->lang->line('Description') ?></label>
                        <div class="col-md-8">
                            <!-- <textarea class="form-control" id="descriptionShow" name="descriptionShow"></textarea> -->
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>
                    </div>
                    <!-- <div class="row form-group">
                        <label class="col-md-4 control-label"
                               for="color"><?php echo $this->lang->line('Color') ?></label>
                        <div class="col-md-4">
                            <input id="color" name="color" type="text" class="form-control input-md"
                                   readonly="readonly"/>
                            <span class="help-block">Click to pick a color</span>
                        </div>
                    </div> -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>


<script src="<?= assets_url() ?>app-assets/vendors/js/extensions/moment.min.js?v=<?= APPVER ?>"></script>
<script src="<?= assets_url() ?>app-assets/vendors/js/extensions/fullcalendar.min.js?v=<?= APPVER ?>"></script>
<!--<script src='< ?php echo assets_url(); ?>assets/c_portjs/main.js?v=< ?= APPVER ?>'></script>-->
<script>
    $('.select-box').select2(

    );
    $(function() {

        var base_url = baseurl; // Here i define the base_url
        /*$.ajax({

            url: base_url+'<?php echo $getEventsURL ?>',
            dataType: 'json',
            success: function (data) {

                console.log(data);
            },
            error: function (data) {
                console.log('error');
            }

        });*/

        var currentDate; // Holds the day clicked when adding a new event
        var currentEvent; // Holds the event object when editing an event

        // $('#color').colorpicker(); // Colopicker




        // Fullcalendar
        $('#calendar').fullCalendar({
            lang: 'en',
            header: {
                left: 'prev, next, today',
                center: 'title',
                right: 'month, basicWeek, basicDay'
            },

            // Get all events stored in database
            eventLimit: true, // allow "more" link when too many events
            events: base_url + '<?php echo $getEventsURL ?>',
            selectable: true,
            selectHelper: true,
            editable: true, // Make the event resizable true
            eventRender: function(event, element, view) {
                const online = event.status === 'accepted' ? '/online' : '';
                return $('<div style="background: ' + event.employee_color + ';border-radius: 3px;padding: 0 3px 0 3px;margin-bottom: 1px;color: white;cursor: pointer">' +
                    moment(event.start).format('HH:mm') + '/' + event.cus_name + online + '</div>');
            },
            select: function(start, end) {
                var thisdate = new Date(start).getFullYear() + '-' + ('0' + (new Date(start).getMonth() + 1)).slice(-2) + '-' + ('0' + (new Date(start).getDate())).slice(-2)
                console.log(thisdate); //2018-06-12T19:30
                document.getElementById("datetime").value = thisdate + "T10:00";
                $('#start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
                $('#end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
                // Open modal to add event
                const eventStart = thisdate + " 10:00:00"
                const eventEnd = calculateMockEndTime(eventStart)
                modal({
                    // Available buttons when adding
                    buttons: {
                        add: {
                            id: 'add-event', // Buttons id
                            css: 'btn-success', // Buttons class
                            label: 'Add' // Buttons label
                        },
                        addservice: {
                            id: 'add-service',
                            css: 'btn-success',
                            label: 'Add new service'
                        }
                    },
                    title: 'Add Event', // Modal title
                    event: {
                        type: 'mock',
                        start: {
                            _i: eventStart
                        },
                        end: {
                            _i: eventEnd
                        }
                    }
                });
            },

            eventDrop: function(event, delta, revertFunc, start, end) {

                start = event.start.format('YYYY-MM-DD HH:mm:ss');
                if (event.end) {
                    end = event.end.format('YYYY-MM-DD HH:mm:ss');
                } else {
                    end = start;
                }


                $.post(base_url + 'events/dragUpdateEvent', 'id=' + event.id + '&start=' + start + '&end=' + end + '&' + crsf_token + '=' + crsf_hash, function(result) {
                    $('.alert').addClass('alert-success').text('Event updated successful');
                    $('.modal').modal('hide');
                    $('#calendar').fullCalendar("refetchEvents");
                    hide_notify();

                });



            },
            eventResize: function(event, dayDelta, minuteDelta, revertFunc) {

                start = event.start.format('YYYY-MM-DD HH:mm:ss');
                if (event.end) {
                    end = event.end.format('YYYY-MM-DD HH:mm:ss');
                } else {
                    end = start;
                }

                $.post(base_url + 'events/dragUpdateEvent', 'id=' + event.id + '&start=' + start + '&end=' + end + '&' + crsf_token + '=' + crsf_hash, function(result) {
                    $('.alert').addClass('alert-success').text('Event updated successful');
                    $('.modal').modal('hide');
                    $('#calendar').fullCalendar("refetchEvents");
                    hide_notify();

                });


            },

            // Event Mouseover
            eventMouseover: function(calEvent, jsEvent, view) {

                var tooltip = '<div class="event-tooltip">' + calEvent.service_name + '</div>';
                $("body").append(tooltip);

                $(this).mouseover(function(e) {
                    $(this).css('z-index', 10000);
                    $('.event-tooltip').fadeIn('500');
                    $('.event-tooltip').fadeTo('10', 1.9);
                }).mousemove(function(e) {
                    $('.event-tooltip').css('top', e.pageY + 10);
                    $('.event-tooltip').css('left', e.pageX + 20);
                });
            },
            eventMouseout: function(calEvent, jsEvent) {
                $(this).css('z-index', 8);
                $('.event-tooltip').remove();
            },
            // Handle Existing Event Click
            eventClick: function(calEvent, jsEvent, view) {
                // Set currentEvent variable according to the event clicked in the calendar
                currentEvent = calEvent;

                // Open modal to edit or delete event
                modal({
                    // Available buttons when editing
                    buttons: {
                        delete: {
                            id: 'delete-event',
                            css: 'btn-danger',
                            label: 'Delete'
                        },
                        update: {
                            id: 'update-event',
                            css: 'btn-success',
                            label: 'Update'
                        }
                    },
                    title: 'Edit Event "' + calEvent.description + '"',
                    event: calEvent
                });
            }
        });

        // Prepares the modal window according to data passed
        function modal(data) {
            // Set modal title
            $('.modal-title').html(data.event ? data.event.cus_name : '');
            // Clear buttons except Cancel
            $('.modal-footer button:not(".btn-default")').remove();
            // Set input values
            $('#title').val(data.event?.title ? data.event.title : '');
            $('#titleShow').val(data.event?.cus_name ? data.event.cus_name : '');
            $('#description').val(data.event?.description ? data.event.description : '');
            $('#descriptionShow').val(data.event?.service_name ? data.event.service_name : '');
            // $('#color').val(data.event?.color ? data.event.color : '#3a87ad');
            $('#datetime').val(data.event?.start ? data.event.start["_i"].replace(" ", "T").slice(0, -3) : '');
            $('#datetimeend').val(data.event?.end ? data.event.end["_i"].replace(" ", "T").slice(0, -3) : '');

            //customerid
            if (data.event && data.event?.type !== 'mock') {
                $('#userid').val(data.event.userid);
                $("#customerid").val(data.event.customerid);
                $("#select2-customerid-container").attr("title", data.event.cus_name);
                $("#select2-customerid-container").text(data.event.cus_name);
                $("#service_id").val(data.event.service_id);
                // $("#customerid").select2().select2('val',data.event.customerid);
                // $('#customerid').val(data.event.customerid);
                // $('#customerid option[value='data.event.customerid']').prop('selected', true);
            }
            //
            // Create Butttons
            $.each(data.buttons, function(index, button) {
                $('.modal-footer').prepend('<button type="button" id="' + button.id + '" class="btn ' + button.css + '">' + button.label + '</button>')
            })
            //Show Modal
            $('.modal').modal('show');
        }

        // Handle Click on Add Button
        $('.modal').on('click', '#add-event', function(e) {

            var str = $('#datetime').val();
            var res = str.replace("T", " ") + ":00";
            var str2 = $('#datetimeend').val();
            var res2 = str2.replace("T", " ") + ":00";
            var customerId = $('#customerid').val();
            if (!str) {
                alert('Start date is required.');
            } else if (!str2) {
                alert('End date is required.');
            } else if (res2 <= res) {
                alert('End date must be bigger than start date.');
            } else if (!customerId) {
                alert('Customer is required.');
            } else {
                var service_id = $('#service_id').val();

                $.ajax({
                    url: base_url + 'events/checkEventExists',
                    type: 'POST',
                    data: '&userid=' + $('#userid').val() + '&datetime=' + res + '&datetimeend=' + res2 + crsf_token + '=' + crsf_hash,
                    async: false,
                    fail: function() {
                        alert('fail');
                    },
                    success: function(data, status) {
                        eventExists = data;
                    },
                });

                if (eventExists == '1') {
                    alert('The selected employee is busy in the selected hours.');
                } else {
                    if (validator(['title', 'description'])) {
                        $.post(base_url + 'events/addAppointment',
                            'title=' + $('#title').val() + '&description=' + $('#description').val() + /* '&color='+$('#color').val()+ */ '&start=' + $('#start').val() + '&end=' + $('#end').val() + '&customerid=' + $('#customerid').val() + '&userid=' + $('#userid').val() + '&datetime=' + res + '&datetimeend=' + res2 + '&service_id=' + service_id + '&' + crsf_token + '=' + crsf_hash,
                            function(result) {
                                $('.alert').addClass('alert-success').text('Event added successful');
                                $('.modal').modal('hide');
                                $('#calendar').fullCalendar("refetchEvents");
                                hide_notify();
                            });
                    }
                }

            }

        });

        // Handle Click on Add Button
        $('.modal').on('click', '#add-service', function(e) {
            var str = $('#datetime').val();
            var res = str.replace("T", " ") + ":00";
            var str2 = $('#datetimeend').val();
            var res2 = str2.replace("T", " ") + ":00";
            var eventExists;
            if (!str) {
                alert('Start date is required.');
            } else if (!str2) {
                alert('End date is required.');
            } else if (res2 <= res) {
                alert('End date must be bigger than start date.');
            } else {
                var service_id = $('#service_id').val();

                $.ajax({
                    url: base_url + 'events/checkEventExists',
                    type: 'POST',
                    data: '&userid=' + $('#userid').val() + '&datetime=' + res + '&datetimeend=' + res2 + crsf_token + '=' + crsf_hash,
                    async: false,
                    fail: function() {
                        alert('fail');
                    },
                    success: function(data, status) {
                        eventExists = data;
                    },
                });

                if (eventExists == '1') {
                    alert('The selected employee is busy in the selected hours.');
                } else {
                    if (validator(['title', 'description'])) {
                        $.post(base_url + 'events/addAppointment',
                            'title=' + $('#title').val() + '&description=' + $('#description').val() + /* '&color='+$('#color').val()+ */ '&start=' + $('#start').val() + '&end=' + $('#end').val() + '&customerid=' + $('#customerid').val() + '&userid=' + $('#userid').val() + '&datetime=' + res + '&datetimeend=' + res2 + '&service_id=' + service_id + '&' + crsf_token + '=' + crsf_hash,
                            function(result) {
                                $('.alert').addClass('alert-success').text('Event added successful');
                                // $('.modal').modal('hide');
                                $('#calendar').fullCalendar("refetchEvents");
                                hide_notify();
                                $('#datetime').val(str2)
                                $('#datetime').change()
                            });
                    }
                }

            }
        });

        // Handle click on Update Button
        $('.modal').on('click', '#update-event', function(e) {
            if (validator(['title', 'description'])) {
                var str = $('#datetime').val();
                var res = str.replace("T", " ") + ":00";
                var str2 = $('#datetimeend').val();
                var res2 = str2.replace("T", " ") + ":00";
                $.post(base_url + 'events/updateEvent', 'id=' + currentEvent.id + '&title=' + $('#title').val() + '&description=' + $('#description').val() + /* '&color='+$('#color').val()+ */ '&employeeid=' + $('#userid').val() + '&serviceid=' + $('#service_id').val() + '&datetime=' + res + '&datetimeend=' + res2 + '&customerid=' + $('#customerid').val() + '&' + crsf_token + '=' + crsf_hash, function(result) {
                    if (result === 'employee is busy') {
                        alert('employee is busy on selected time, please select a different time or employee')
                    } else {
                        $('.alert').addClass('alert-success').text('Event updated successful');
                        $('.modal').modal('hide');
                        $('#calendar').fullCalendar("refetchEvents");
                        hide_notify();
                    }
                });
            }
        });
        //hide color
        $("#link_to_cal").change(function() {

            $('#hidden_div').show();


        });


        // Handle Click on Delete Button

        $('.modal').on('click', '#delete-event', function(e) {
            $.get(base_url + 'events/deleteEvent?id=' + currentEvent.id, function(result) {
                $('.alert').addClass('alert-success').text('Event deleted successful !');
                $('.modal').modal('hide');
                $('#calendar').fullCalendar("refetchEvents");
                hide_notify();
            });
        });

        function hide_notify() {
            setTimeout(function() {
                $('.alert').removeClass('alert-success').text('');
            }, 2000);
        }


        // Dead Basic Validation For Inputs
        function validator(elements) {
            var errors = 0;
            /*  $.each(elements, function(index, element){
                  if($.trim($('#' + element).val()) == '') errors++;
              });
              if(errors) {
                  $('.error').html('Please insert title and description');
                  return false;
              }*/
            return true;
        }

        $('#adate').fullCalendar({
            lang: 'en',
            header: {
                left: 'prev, next, today',
                center: 'title',
                right: 'month, basicWeek, basicDay'
            },
            // Get all events stored in database
            eventLimit: true, // allow "more" link when too many events
            events: base_url + 'user/getAttendance',
            selectable: false,
            selectHelper: false,
            editable: false, // Make the event resizable true
            select: function(start, end) {

                $('#start').val(moment(start + ' 00:00:00').format('YYYY-MM-DD HH:mm:ss'));
                $('#end').val(moment(end + ' 00:00:00').format('YYYY-MM-DD HH:mm:ss'));

            }





        });

        $('#holidays').fullCalendar({
            lang: 'en',
            header: {
                left: 'prev, next, today',
                center: 'title',
                right: 'month, basicWeek, basicDay'
            },
            // Get all events stored in database
            eventLimit: true, // allow "more" link when too many events
            events: base_url + 'user/getHolidays',
            selectable: false,
            selectHelper: false,
            editable: false, // Make the event resizable true
            select: function(start, end) {

                $('#start').val(moment(start + ' 00:00:00').format('YYYY-MM-DD HH:mm:ss'));
                $('#end').val(moment(end + ' 00:00:00').format('YYYY-MM-DD HH:mm:ss'));

            }





        });

        function calculateMockEndTime(startTime) {
            const dateObj = new Date(startTime);
            const estimation = parseInt($("#service_id :selected").data('servicetime'))
            dateObj.setMinutes(dateObj.getMinutes() + estimation)
            return moment(dateObj).format('YYYY-MM-DD[T]HH:mm:ss')
        }

        function filterEmployee(serviceId) {
            const employeeDropDown = $("#userid")[0]
            let firstOption = undefined;
            $.each(employeeDropDown.options, function(index, option) {
                option = $(option);
                if (option.data('serviceid').includes(serviceId)) {
                    option.removeAttr('disabled')
                    if (firstOption === undefined) firstOption = option.val()
                } else {
                    option.attr('disabled', 'true')
                }
            })
            employeeDropDown.value = firstOption;
        }

        function filterService(availabeServices) {
            const servicesDropDown = $("#service_id")[0]
            let firstOption = undefined;
            $.each(servicesDropDown.options, function(index, option) {
                const optionValue = parseInt(option.value)
                option = $(option);
                if (availabeServices.includes(optionValue)) {
                    option.removeAttr('disabled')
                    if (firstOption === undefined) firstOption = optionValue
                } else {
                    option.attr('disabled', 'true')
                }
            })
            servicesDropDown.value = firstOption;
        }

        function setEndTime(estimation) {
            const start = $('#datetime').val();
            const dateObj = new Date(start);
            dateObj.setMinutes(dateObj.getMinutes() + estimation)
            $('#datetimeend').val(moment(dateObj).format('YYYY-MM-DD[T]HH:mm:ss'))
        }

        $("#datetime").on("change", function(event) {
            const value = event.target.value
            const end = calculateMockEndTime(value)
            $("#datetimeend").val(end);
        })

        $("#service_id").on("change", function(event) {
            let target = event.target;
            // selectedService = parseInt(target.value);
            // filterEmployee(selectedService);
            selected = $(target)[0].selectedOptions[0];
            const estimation = parseInt($(selected).data('servicetime'));
            setEndTime(estimation);
        })

        $("#userid").on("change", function(event) {
            const selectedUser = $(event.target.selectedOptions[0])
            const availableServices = selectedUser.data('serviceid');
            filterService(availableServices);
        })

        // if (parseInt($("#service_id").val()) != NaN) {
        //     const service = $("#service_id");
        //     filterEmployee(parseInt(service.val()));
        //     // setEndTime(parseInt(service.data('servicetime')));
        // }

        if (parseInt($("#userid").val()) != NaN) {
            const availableServices = $("#userid :selected").data('serviceid');
            filterService(availableServices);
        }

    });
</script>
<?php /*
 Code for localization
<script src="<?= assets_url() ?>app-assets/vendors/js/fullcalendar/locale/es.js?v=<?= APPVER ?>"></script>
 */
