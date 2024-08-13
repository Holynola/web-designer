$(document).ready(function() {
    $('#doyenne').on('change',function() {
        var choix = $(this).val();

        if (choix) {
            $.ajax({
                type:'POST',
                url:'add-section.php',
                data:'choi='+choix,
                success:function(html){
                    $('#section').html(html);
                }
            });
        }
    });
});