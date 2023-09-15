let jobs = {
    init: () => {
        jobs.load();
        jobs.applyJobActions();
    },

    load: () => {
        let data = {'action': 'loadAll'};
        $.ajax({
            url: 'process/job.php',
            data: data,
            type: 'POST',
            success: (response) => {
                response = JSON.parse(response)
                if(response.success && response.jobs.length)
                {
                    jobs.drawJobs(response.jobs);
                }
            }
        });
    },


    drawJobs: (jobs) => {
        let html = '';
        for(let i in jobs)
        {
            let job = jobs[i]; 
            let created_at = job.created_timestamp ? timeSince(new Date(job.created_timestamp)) : '----';
            let salary_from = !job.salary_from ? 'N/A' : '$'+job.salary_from;
            let salary_to = !job.salary_to ? 'N/A' : '$'+job.salary_to;

            html += '<div id="'+ job.id +'" class="single-job-items mb-30">';
            html += '<div class="job-items">';
            html += '<div class="company-img">';
            html += '   <a href="#"><img src="assets/img/icon/job-list1.png" alt=""></a>';
            html += '</div>';
            html += '<div class="job-tittle job-tittle2">';
            html += '<a href="job_details.php?slug='+ job.slug + '">';
            html += '   <h4>'+ job.title +'</h4>';
            html += '</a>';

            html += '<ul>';
            html += '<li>Creative Agency</li>';
            html += '<li><i class="fas fa-map-marker-alt"></i>'+ job.location +'</li>';
            html += '<li>'+ salary_from +' - '+ salary_to +'</li>';
            html += '</ul>';
            html += '</div>';

            html += '</div>';
            html += '<div class="items-link items-link2 f-right">';
            html += '<a href="job_details.html">'+ job.job_nature +'</a>';
            html += '<span>'+ created_at +'</span>';
            html += '</div>';
            html += '</div>';
        }

        $(".jobs-container").html(html);
        $(".count-job > span").html(jobs.length + " Jobs Found");
    },

    applyJobActions: () => {
        
    },
};

$( document ).ready(function() {
    jobs.init();
});