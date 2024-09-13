<script>
    (function ($) {
        "use strict";

        let header_token = $('#header_token').val();
        $(document).ready(function () {

            addMenu('Course', '#add_course_page_btn', $('#courseInput'));

        });

        function addMenu(type, btn, input) {

            $(document).on('click', btn, function (event) {

                if (!checkDemo()) {
                    return false;
                }

                let dPages = input.val();
                let url = $('#course_add_url').val();
                let plan_id = $('#plan_id').val();


                input.val('');
                let dataRow = {
                    'type': type,
                    'element_id': dPages,
                    'plan_id': plan_id,
                    '_token': header_token
                }


                $.post(url, dataRow, function (data) {

                    if (data) {
                        blankData();
                        toastr.success("Operation successful", "Successful", {timeOut: 5000,});
                        reloadWithData(data);
                    } else {
                        toastr.error("Operation failed", "Error", {timeOut: 5000,});
                    }
                });

            });
        }

        function checkDemo() {
            let demoMode = $('#demoMode').val();
            if (demoMode) {
                toastr.warning("For the demo version, you cannot change this", "Warning");
                return false;
            } else {
                return true;
            }
        }

        $(document).on("click", ".deleteBtn", function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            if (!checkDemo()) {
                return false;
            }
            $('#deleteSubmenuItem').modal('show');
            $('#item-delete').val(id);
        });


        function reloadWithData(response) {

            $('#courseList').empty();
            $('#courseList').html(response);
        }

        function blankData() {

        }


        $(document).on('click', '#delete-item', function (event) {
            event.preventDefault();
            if (!checkDemo()) {
                return false;
            }
            let url = $('#bundle_course_delete_url').val();
            $('#deleteSubmenuItem').modal('hide');
            let id = $('#item-delete').val();
            let data = {
                'id': id,
                '_token': header_token,
            }
            $.post(url, data,
                function (data) {
                    reloadWithData(data);
                });
        });

    })(jQuery);

</script>
