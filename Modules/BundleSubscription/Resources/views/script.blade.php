<script>

    (function ($) {
        "use strict";

        $('tbody').sortable({
            cursor: "move",
            update: function (event, ui) {
                let ids = $(this).sortable('toArray', {attribute: 'data-item'});
                if (ids.length > 0) {
                    let data = {
                        '_token': '{{ csrf_token() }}',
                        'ids': ids,
                    }
                    $.post("{{route('instructor.position')}}", data, function (data) {

                    });
                }
            }
        });

    })(jQuery);


</script>


