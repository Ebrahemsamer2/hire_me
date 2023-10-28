let myJobsManager = {
    userType: '',
    init: () => {
        if(typeof userType != undefined && userType) {
            myJobsManager.userType = userType;
        }
        myJobsManager.drawMyJobs();
        myJobsManager.applyActions();
    },
    drawMyJobs: () => {
        myJobsManager.loadMyJobs((myJobs) => {
            if(myJobsManager.userType == 'employer') {
                $(".myjobs-list").html("<p class='text-center p-4 h4'>You did not post any jobs.</p>");
            } else {
                $(".myjobs-list").html("<p class='text-center p-4 h4'>You did not apply to any job.</p>");
            }
            if(myJobs.length) {
                if(myJobsManager.userType == 'employee') {
                    $(".myjobs-list").html("<p class='p-4 h4'>Jobs you have applied to</p>");
                } else {
                    $(".myjobs-list").html("<p class='p-4 h4'>Jobs you have created</p>");
                }
            }

            myJobs.forEach(job => {
                myJobsManager.drawJob(job);
            });
        });
    },
    applyActions: () => {

    },
    
    drawJob: (job) => { console.log(timeSince(job.created_timestamp));
        let created_at = job.created_timestamp ? timeSince(new Date(job.created_timestamp)) : '----';
        let salary_from = !job.salary_from ? 'N/A' : '$'+job.salary_from;
        let salary_to = !job.salary_to ? 'N/A' : '$'+job.salary_to;
        let avatar = job.avatar ? 'assets/img/avatar/' + job.avatar : 'assets/img/company.png';
        let html = '<div class="col-md-12">';

        html += '<div id="'+ job.id +'" class="single-job-items mb-30">';
        html += '<div class="job-items">';
        html += '<div class="company-img">';
        html += '   <a href="#"><img width="100" src="'+ avatar +'" alt=""></a>';
        html += '</div>';
        html += '<div class="job-tittle job-tittle2">';
        html += '<a href="job_details.php?slug='+ job.slug + '">';
        html += '   <h4>'+ job.title +'</h4>';
        html += '</a>';

        html += '<ul>';
        html += '<li>'+ job.username +'</li>';
        html += '<li><i class="fas fa-map-marker-alt"></i>'+ job.location +'</li>';
        html += '<li>'+ salary_from +' - '+ salary_to +'</li>';
        html += '</ul>';

        if(myJobsManager.userType == 'employer'){
            html += '<a href="job_applicants.php?slug='+ job.slug +'" class="border-btn2 p-2">Applicants</a>';
        }

        html += '</div>';

        html += '</div>';
        html += '<div class="items-link items-link2 f-right">';
        html += '<span class="text-success">'+ job.status.toUpperCase() +'</span>';
        html += '<span>'+ created_at +'</span>';
        html += '</div>';
        html += '</div>';

        html += '</div>';

        $(".myjobs-list").append(html);
    },

    loadMyJobs: (callback) => {
        let data = {};
        if(myJobsManager.userType == 'employer'){
            data = {'action': 'loadAuthorJobs'};
        } else {
            data = {'action': 'loadMyJobs'};
        }
        $.ajax({
            url: 'process/job_user.php',
            data: data,
            type: 'POST',
            success: (response) => {
                response = JSON.parse(response);
                if(response.success)
                {
                    if(typeof response.myJobs != undefined && response.myJobs) {
                        callback(response.myJobs);
                    }
                }
            }
        });
    }
};

$( document ).ready(function() {
    myJobsManager.init();
});