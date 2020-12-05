$(document).ready(function() {
    $('.image_trigger').click(function (e) {
        const inputTarget = $(this).data('input_target');
        $(inputTarget).click();
    });

    $('.upload_item_input').change(function (e) {
        const file = e.target.files[0];
        const eid = $(this).data('eid');
        const img = $(eid + ' img');
        const imgDefault = img.data('default');
        if (file) {
            img.attr('src', window.URL.createObjectURL(file));
            img.attr('style', "max-width: 90px;max-height: 90px; ");
        }else{
            $(eid + ' img').attr('src', imgDefault);
            img.attr('style', "max-width: 50px;max-height: 50px; ");
        }
    });

    laydate.render({
        elem: '#endTime', //指定元素
        type: 'datetime'
    });
});
