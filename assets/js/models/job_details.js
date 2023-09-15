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
                } else {
                    message.show(response.message);
                    location.href = "404.php";
                }
            }
        });
    },


    drawJob: (jobObj) => {
        let company_image_src = "assets/img/icon/job-list1.png";
        
        $(".hero-cap > h2").text(jobObj.title);
        $(".job-tittle > a > h4").text(jobObj.title);

        // Image data
        $(".company-img > a > img").attr("src", company_image_src);
        $(".company-img > a > img").attr("alt", jobObj.title);

        $(".job-tittle > ul li.company_name").text(jobObj.employer.username);
        $(".job-tittle > ul li.location").html('<i class="fas fa-map-marker-alt"></i> ' + jobObj.location);
        $(".job-tittle > ul li.salary").text("$" + jobObj.salary_from + " - " + jobObj.salary_to);

        $(".job-post-details .post-details1 p").text(jobObj.description);

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
        
    },
};

$( document ).ready(function() {
    job.init();
});