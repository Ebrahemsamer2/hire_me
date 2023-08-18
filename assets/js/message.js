let message = 
{
    show: (content) => {
        $("#message").html(content);
        $("#message").show();

        setTimeout(() => {
            $("#message").hide();
        }, 3000);
    }
};