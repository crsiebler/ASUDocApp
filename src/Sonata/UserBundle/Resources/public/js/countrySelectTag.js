$(document).ready(function () {
    $('select[id*="addressForm_country"]').change(function () {
        $.fancybox.showLoading();
        $this = $(this);
        scope = "est";
       
        url = $this.parent().parent().parent().parent().data('countryurl');
       
        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            data: "country="+$this.val(),
            success: function (result) {
                $.fancybox.hideLoading();
                $selectTag = $('select[id*="addressForm_state"]', $this.parent().parent());
                $selectTag.html();
                $selectTag.removeAttr('disabled');
                selectOptions = '<option value="">Please select a state</option>';
                
                $.each(result, function (index, element) {
                   selectOptions = selectOptions + '<option value="'+element.id+'">'+element.name+'</option>';
                })
                
                $selectTag.html(selectOptions);
            }
        });
    });
    
    
    $('select[id*="addressDoubleForm_country"]').change(function () {
        $.fancybox.showLoading();
        $this = $(this);
        scope = "est";
       
        url = $this.parent().parent().parent().parent().data('countryurl');
       
       console.log(url);
       console.log($this.parent().parent().parent().parent());
       
        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            data: "country="+$this.val(),
            success: function (result) {
                $.fancybox.hideLoading();
                $selectTag = $('select[id*="addressDoubleForm_state"]', $this.parent().parent());
                $selectTag.html();
                $selectTag.removeAttr('disabled');
                selectOptions = '<option value="">Please select a state</option>';
                
                $.each(result, function (index, element) {
                   selectOptions = selectOptions + '<option value="'+element.id+'">'+element.name+'</option>';
                })
                
                $selectTag.html(selectOptions);
            }
        });
    })
});