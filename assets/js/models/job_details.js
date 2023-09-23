let job = {
    init: () => {
        job.load();
        job.applyJobActions();
    },

    load: () => {
        let data = {'action': 'load'};
        data.slug = getUrlParameter('slug');
        $.ajax({
            url: 'process/job.php',
            data: data,
            type: 'POST',
            success: (response) => {
                response = JSON.parse(response)
                if(response.success && response.job)
                {
                    job.drawJob(response.job);
                    let applied_by_current_user = response.applied_by_current_user;
                    if(applied_by_current_user)
                    {
                        $("#apply_now").remove();
                        $(".apply-btn2").html("<span class='already_applied'>Already Applied</span>");
                    }
                } else {
                    message.show(response.message);
                    location.href = "404.php";
                }
            }
        });
    },


    drawJob: (jobObj) => {
        let company_image_src = "assets/img/icon/job-list1.png";
        let username = jobObj.employer.username;
        let web = jobObj.employer.web;
        let email = jobObj.employer.email;
        let about_me = jobObj.employer.about_me;
        
        let posted_date = job.created_timestamp ? timeSince(new Date(job.created_timestamp)) : 'N/A'
        let location = jobObj.location;
        let vacancy_number = jobObj.vacancy_number;
        let job_nature = jobObj.job_nature;

        let salary_from = !jobObj.salary_from ? 'N/A' : '$'+jobObj.salary_from;
        let salary_to = !jobObj.salary_to ? 'N/A' : '$'+jobObj.salary_to;
        let salary = salary_from + ' - ' + salary_to;

        
        $(".hero-cap > h2").text(jobObj.title);
        $(".job-tittle > a > h4").text(jobObj.title);

        // Image data
        $(".company-img > a > img").attr("src", company_image_src);
        $(".company-img > a > img").attr("alt", jobObj.title);

        $(".job-tittle > ul li.company_name").text(username);
        $(".job-tittle > ul li.location").html('<i class="fas fa-map-marker-alt"></i> ' + jobObj.location);
        $(".job-tittle > ul li.salary").text("$" + jobObj.salary_from + " - " + jobObj.salary_to);

        $(".job-post-details .post-details1 p").text(jobObj.description);
        
        // post-details3
        $(".post-details3 ul li.date > span").text(posted_date);
        $(".post-details3 ul li.location > span").text(location);
        $(".post-details3 ul li.vacancy > span").text(vacancy_number);
        $(".post-details3 ul li.job_nature > span").text(job_nature);
        $(".post-details3 ul li.salary > span").text(salary);

        // post-details4
        $(".post-details4 .username").text(username);
        $(".post-details4 p.about_me").text(about_me);
        $(".post-details4 ul li.username span").text(username);
        $(".post-details4 ul li.web span a").text(web);
        $(".post-details4 ul li.web span a").attr("href", web);
        $(".post-details4 ul li.email span").text(email);

        job.drawRequiredKnowledge(jobObj.required_knowledge);
        job.drawEducationExperience(jobObj.education_experience);
        
    },

    drawRequiredKnowledge: (knowledge) => {
        if(knowledge)
        {
            let html = '';
            let knowledge_sentences = knowledge.split(";");
            for(let index in knowledge_sentences)
            {
                html += '<li>' + knowledge_sentences[index] + '</li>';
            }
            $(".job-post-details .knowledge > ul").html(html);
        }
    },
    drawEducationExperience: (experience) => {
        if(experience)
        {
            let html = '';
            let experience_sentences = experience.split(";");
            for(let index in experience_sentences)
            {
                html += '<li>' + experience_sentences[index] + '</li>';
            }
            $(".job-post-details .experience > ul").html(html);
        }
    },

    applyJobActions: () => {
        $("#apply_now").on("click", (e) => {
            e.preventDefault();
            let data = {'action': 'apply'};
            data.slug = getUrlParameter('slug');
            $.ajax({
                url: 'process/job_user.php',
                data: data,
                type: 'POST',
                success: (response) => {
                    response = JSON.parse(response)
                    if(response.success)
                    {
                        $("#apply_now").remove();
                        $(".apply-btn2").html("<span class='already_applied'>Already Applied</span>");
                    }
                    message.show(response.message)
                }
            });
        });
    },
};

$( document ).ready(function() {
    job.init();
});