let userProfile = {
    init: () => {
        userProfile.load();
        userProfile.applyProfileActions();
    },

    load: () => {
        let data = {'action': 'loadProfile'};
        $.ajax({
            url: 'process/user.php',
            data: data,
            type: 'POST',
            success: (response) => { 
                response = JSON.parse(response)
                if(response.success && response.user)
                {
                    userProfile.populate(response.user);
                } else {
                    message.show(response.message);
                }
            }
        });
    },

    resetPassword: () => { 
        $("#old_password").val("");
        $("#new_password").val("");
        $("#confirmation").val("");
    },

    populate: (user) => { 
        $("#username").val(user.username);
        $("#email").val(user.email);
        $("#web").val(user.web);
        $("#about_me").text(user.about_me);
    },

    collectData: () => {
        let data = {};
        data.username = $("#username").val();
        data.email = $("#email").val();
        data.web = $("#web").val();
        data.about_me = $("#about_me").val();

        data.old_password = $("#old_password").val();
        data.new_password = $("#new_password").val();
        data.confirmation = $("#confirmation").val();

        if(! data.username || ! data.email) {
            message.show("Username and email are required");
            return false;
        }
        if(data.new_password && !isValidPassowrd(data.new_password)) { 
            message.show("Invalid New Password");
            return false; 
        }
        if(data.new_password && data.new_password != data.confirmation) { 
            message.show("Invalid confirmation password");
            return false; 
        }
        return data;
    },

    applyProfileActions: () => {

        $("#new_password").on("input", (e) => {
            let new_password = $(e.target).val().trim();
            $("#password_rules").removeAttr('class');
            if(isValidPassowrd(new_password))
            {
                $("#password_rules").addClass("mb-4 small text-success");
            } else {
                $("#password_rules").addClass("mb-4 small text-danger");
            }
        });

        $("#profile_form .save").on("click", (e) => {
            e.preventDefault();
            let data = userProfile.collectData();
            if(data) {
                data.action = 'saveProfile';
                $.ajax({
                    url: 'process/user.php',
                    data: data,
                    type: 'POST',
                    success: (response) => {
                        response = JSON.parse(response)
                        if(response.success)
                        {
                            userProfile.resetPassword();
                        }
                        message.show(response.message)
                    }
                });
            }
        });
    },
};

$( document ).ready(function() {
    userProfile.init();
});