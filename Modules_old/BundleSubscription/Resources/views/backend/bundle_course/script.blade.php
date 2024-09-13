<script>

    (function ($) {
        "use strict";

        $('tbody').sortable({
            cursor: "move",
            update: function (event, ui) {


                var ids = [];
                $('.switch_toggle').each(function(){
                    var $this = $(this);
                    console.log($this.data('item'))
                    ids.push($this.data('item'));
                });

                if (ids.length > 0) {
                    let data = {
                        '_token': '{{ csrf_token() }}',
                        'ids': ids,
                    }
                    $.post("{{route('change.position')}}", data, function (data) {

                    });
                }
            }
        });


        $(document).on('click', '.editplan', function () {

            let plan = $(this).data('item');

            console.log(plan)

            $('#planId').val(plan.id);
            $('#editTitle').val(plan.title);
            $('#editPrice').val(plan.price);
            $('#editAbout').val(plan.about);
            $('#editBtnTxt').val(plan.button_text);
            $('#editDays').val(plan.days);
            $('#icon').val(plan.icon.substring(plan.icon.lastIndexOf("/") + 1, plan.icon.length));

            $("#editplan").modal('show');


        });


        $(document).on('click', '.deleteplan', function () {
            let id = $(this).data('id');
            $('#planDeleteId').val(id);
            $("#deleteplan").modal('show');
        });


        $(document).on('click', '#add_plan_btn', function () {
            $('#addTitle').val('');
            $('#addPrice').val('');
            $('#addAbout').val('');
            $('#addSchedule').val('');
            $('#addDays').val('');
            $('#addBtn').val('');
        });


    })(jQuery);


    function update_status(el) {

        console.log('testttt',el)

        if (el.checked) {
            var status = 1;
        } else {
            var status = 0;
        }
        $.post('{{ route('change.status') }}', {
            _token: '{{ csrf_token() }}',
            id: el.value,
            status: status
        }, function (data) {

        });
    }




</script>






@if ($errors->any())
    <script>
        @if(Session::has('type'))
        @if(Session::get('type')=="store")
        $('#add_plan').modal('show');
        @else
        $('#editplan').modal('show');
        @endif
        @endif
    </script>
@endif
