let user = {
    init: () => {
        user.applyUserActions();
    },
    register: () => {
        let data = user.collectData();
        $.ajax({
            url: 'process/user.php',
            data: data,
            type: 'POST',
            success: (response) => {
                response = JSON.parse(response)
                message.show(response.message);
                if(response.success)
                {
                    setTimeout(() => {
                        location.href = "index.php";
                    }, 2000);
                }
            },
        });
    },

    collectData: () => {
        let data = {};
        data.first_name = $(".register input[name='first_name']").val();
        data.last_name = $(".register input[name='last_name']").val();
        data.email = $(".register input[name='email']").val();
        data.type = $(".register input[name='type']").val();
        data.password = $(".register input[name='password']").val();
        data.confirmation = $(".register input[name='confirmation']").val();

        data.action = 'register';
        return data;
    },
    
    applyUserActions: () => {
        $(".btnRegister").on("click", () => {
            user.register();
        });
    },
};

user.init();