let home = {
    categories: [],
    init: () => {
        category.loadAll((response) => {
            home.categories = response.categories;
            home.populateCategories();
            home.loadForYouJobs((jobs) => {
                let html = ``;
                jobs.forEach((job) => {
                    let logo = job.avatar ? "assets/img/avatar/" + job.avatar : "assets/img/company.png";
                    let created_at = job.created_timestamp ? timeSince(new Date(job.created_timestamp)) : '----';
                    let salary_from = !job.salary_from ? 'N/A' : '$'+job.salary_from;
                    let salary_to = !job.salary_to ? 'N/A' : '$'+job.salary_to;
                    let job_nature = formatJobNature(job.job_nature);
                    html += `
                        <div class="single-job-items mb-30">
                            <div class="job-items">
                                <div class="company-img">
                                    <a href="job_details.php?slug=${job.slug}">
                                    <img width="100" src="${logo}" alt=""></a>
                                </div>
                                <div class="job-tittle">
                                    <a href="job_details.php?slug=${job.slug}"><h4>${job.title}</h4></a>
                                    <ul>
                                        <li>${job.username}</li>
                                        <li><i class="fas fa-map-marker-alt"></i>${job.location}</li>
                                        <li>${salary_from} - ${salary_to}</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="items-link f-right">
                                <a href="job_details.php?slug=${job.slug}">${job_nature}</a>
                                <span>${created_at}</span>
                            </div>
                        </div>
                    `;
                });
                $(".featured-jobs").html(html);
            });
        });

        home.applyActions();
    },

    applyActions: () => {
        $("#find-job").on("click", (e) => {
            e.preventDefault();

            let job_title = $("input[name='title']").val();
            let job_location = $("select[name='location']").val();
            if(job_title && job_location){
                location.href=`job_listing.php?title=${job_title}&location=${job_location}`;
            } else if (job_title) {
                location.href=`job_listing.php?title=${job_title}`;
            } else if(job_location) {
                location.href=`job_listing.php?location=${job_location}`;
            } else {
                message.show("Invalid Data");
            }
        });
    },
    populateCategories: () => {
        let html = '';
        home.categories.forEach((category) => {
            html += `
            <div id='category-${category.id}' class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                <div class="single-services text-center mb-30">
                    <div class="services-cap">
                        <h5><a href="job_listing.php?category=${category.slug}">${category.name}</a></h5>
                        <span>(${category.jobsCount})</span>
                    </div>
                </div>
            </div>
            `;
        });
        $(".home-categories").html(html);
    },

    loadForYouJobs: (callback) => {
        let data = {'action': 'loadForYouJobs'};
        $.ajax({
            url: 'process/job.php',
            data: data,
            type: 'POST',
            success: (response) => {
                response = JSON.parse(response)
                if(response.success)
                {
                    if(typeof response.jobs != undefined && response.jobs) {
                        callback(response.jobs);
                    } else {
                        $(".featured-jobs").html("<p class='text-center h4'>No Jobs has found</p>");
                    }
                }
            }
        });
        
    },
}

$( document ).ready(function() {
    home.init();
});