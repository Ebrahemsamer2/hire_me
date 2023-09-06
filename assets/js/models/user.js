let user = {
    init: () => {
        user.applyUserActions();
    },
    register: () => {
        let data = user.collectRegisterFormData();
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

    login: () => {
        let data = user.collectLoginFormData();
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
            error: (response) => {
                console.log(response);
            },
        });
    },

    logout: () => {
        let data = {'action': 'logout'};
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
                    }, 1000);
                }
            },
        });
    },

    collectRegisterFormData: () => {
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

    collectLoginFormData: () => {
        let data = {};
        data.email = $(".register input[name='email']").val();
        data.password = $(".register input[name='password']").val();
        data.action = 'login';
        return data;
    },
    
    applyUserActions: () => {
        $("input[name='register']").on("click", () => {
            user.register();
        });

        $("input[name='login']").on("click", () => {
            user.login();
        });

        $("#logout").on("click", (e) => {
            e.preventDefault();
            console.log("A");
            user.logout();
        });
    },
};

user.init();