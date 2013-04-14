$(document).ready(function () {
    $('select[id*="addressForm_country"]').change(function () {
        url = $(this).parent().parent().parent().parent().data('countryurl');

        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            data: "country="+$(this).val(),
            success: function (result) {
                selectTag = $('select[id*="addressForm_state"]');
                selectTag.html();
                
                // Test to see if JSON Response is Empty
                if (!$.isEmptyObject(result)) {
                    selectTag.attr('disabled', false);
                    selectTag.removeClass('error');
                    selectTag.parent().parent().removeClass('error');
                    $('div[id^="addressForm_state"] > div > span[class*="help-block"]').hide();
                    $('div[class="symfony-form-errors"]').hide();
                } else {
                    selectTag.attr('disabled', true);
                }
                selectOptions = '<option value="" disabled="disabled">Please select a state</option>';

                $.each(result, function (index, element) {
                    selectOptions = selectOptions + '<option value="'+element.id+'">'+element.name+'</option>';
                });

                selectTag.html(selectOptions);
            }
        });
    });
    
    $('select[id*="addressForm_state"]').change(function () {
        if ($(this).hasClass('error')) {
            $(this).removeClass('error');
            $(this).parent().parent().removeClass('error');
            $('div[id^="addressForm_state"] > div > span[class*="help-block"]').hide();
            $('div[class="symfony-form-errors"]').hide();
        }
    });
});