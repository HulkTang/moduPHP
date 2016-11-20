//add file
$(document).ready(function(){
    $("#selectFileBtn").click(function(){
        $fileField = $('<input type="file" name="thumbs[]"/>');
        $fileField.hide();
        $("#attachList").append($fileField);
        $fileField.trigger("click");
        $fileField.change(function(){
            $path = $(this).val();
            $filename = $path.substring($path.lastIndexOf("\\")+1);
            $attachItem = $('<div class="attachItem"><div class="left"></div></div>');
            $attachItem.find(".left").html($filename);
            $("#attachList").append($attachItem);
        });
    });
    $("#attachList>.attachItem").find('a').live('click',function(obj,i){
        $(this).parents('.attachItem').prev('input').remove();
        $(this).parents('.attachItem').remove();
    });
});
