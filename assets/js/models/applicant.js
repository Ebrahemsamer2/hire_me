let applicant = {
    init: () => {
        applicant.applyActions();
    },
    applyActions: () => {
        $("#download-applicant-resume").on("click", (e) => {
            e.preventDefault();
            let data = {"action": "download_resume"};
            data.user_email = $(e.target).parents(".applicant").attr("data-email");
            data.job_slug = $(e.target).parents(".applicant").attr("data-slug");
            
            $.ajax({
                url: 'process/user.php',
                data: data,
                type: 'POST',
                success: (response) => {
                    response = JSON.parse(response);
                    message.show(response.message);
                    if(response.success)
                    {
                        let resume_filename = response.resume_filename;
                        window.open("assets/resumes/" + resume_filename, "_blank");
                    }
                }
            });
        });
    },
};

$(document).ready(function() {
    applicant.init();
});
