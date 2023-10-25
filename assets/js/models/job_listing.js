let jobsManager = {
    filters: {},
    sidebarLocations: [],
    sidebarCategories: [],
    loadingMore: false,
    lastJobsCount: 0,
    offset: 0,
    limit: 50,

    init: () => {
        let current_url = window.location.href;
        jobsManager.filters = jobsManager.getFilters(current_url);

        jobsManager.load();
        jobsManager.applyJobActions();
    },

    load: () => {
        let data = {'action': 'loadAll', 'filters': jobsManager.filters, 'offset': jobsManager.offset};
        $.ajax({
            url: 'process/job.php',
            data: data,
            type: 'POST',
            async: false,
            success: (response) => {
                response = JSON.parse(response)
                if(response.success)
                {
                    jobsManager.lastJobsCount = response.jobs.length;
                    jobsManager.sidebarLocations = response.locations;
                    jobsManager.sidebarCategories = response.categories;
                    jobsManager.drawJobs(response.jobs);
                    if(!jobsManager.loadingMore)
                    {
                        jobsManager.populateSidebarFilters(() => {
                            let category = getUrlParameter('category');
                            let location = getUrlParameter('location');

                            $("select[name='category']").val(category ? category : 0);
                            $("select[name='location']").val(location ? location.replaceAll("+", " ") : 0);

                            let selected_job_natures = getUrlParameter('job_nature');
                            if(selected_job_natures)
                            {
                                selected_job_natures = selected_job_natures.split(",");
                                selected_job_natures.forEach((job_nature) => {
                                    $("input[name='job_nature'][value='"+ job_nature +"']").attr("checked", "checked");
                                });
                            }

                            let selected_experiences = getUrlParameter('experience');
                            if(selected_experiences)
                            {
                                selected_experiences = selected_experiences.split(",");
                                selected_experiences.forEach((experience) => {
                                    $("input[name='experience'][value='"+ experience +"']").attr("checked", "checked");
                                });
                            }
                        });
                    }
                }
            }
        });
    },

    loadMore: () => {
        jobsManager.loadingMore = true;
        jobsManager.offset += 50;
        if(jobsManager.lastJobsCount == jobsManager.limit) {
            jobsManager.load();
        }
    },

    getFilters: (filters_url) => {
        let filters = filters_url.split("?")[1];
        let filters_obj = {};
        if(filters) {
            filters = filters.split("&");
            filters.map((value, index) => {
                let key = filters[index].split("=")[0];
                let val = filters[index].split("=")[1];
                filters_obj[key] = val;
            });
        }
        return filters_obj;
    },

    populateSidebarFilters: (callback) => {
        // Populate job locations
        let html = ``;
        html += `<option value='0'>Anywhere</option>`;
        jobsManager.sidebarLocations.forEach((location) => {
            html += `<option value='${location}'>${location}</option>`;
        });
        $("select[name='location']").html(html);

        // Populate job categories
        html = ``;
        html += `<option value='0'>All Categories</option>`;
        jobsManager.sidebarCategories.forEach((category) => {
            html += `<option value='${category.slug}'>${category.name}</option>`;
        });
        $("select[name='category']").html(html);
        callback();
    },

    drawJobs: (jobs) => {
        let html = '';
        for(let i in jobs)
        {
            let job = jobs[i]; 
            let created_at = job.created_timestamp ? timeSince(new Date(job.created_timestamp)) : '----';
            let salary_from = !job.salary_from ? 'N/A' : '$'+job.salary_from;
            let salary_to = !job.salary_to ? 'N/A' : '$'+job.salary_to;
            let job_nature = formatJobNature(job.job_nature);

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
            html += '<li>'+ job.username +'</li>';
            html += '<li><i class="fas fa-map-marker-alt"></i>'+ job.location +'</li>';
            html += '<li>'+ salary_from +' - '+ salary_to +'</li>';
            html += '</ul>';
            html += '</div>';

            html += '</div>';
            html += '<div class="items-link items-link2 f-right">';
            html += '<a href="job_details.html">'+ job_nature +'</a>';
            html += '<span>'+ created_at +'</span>';
            html += '</div>';
            html += '</div>';
        }

        if(jobsManager.loadingMore) {
            $(".jobs-container").append(html);
        } else {
            $(".jobs-container").html(html);
        }
        $(".count-job > span").html(jobs.length + " Jobs Found");
    },

    applyJobActions: () => {
        $("select[name='category']").on("change", (e) => {
            jobsManager.reset();

            let category = $(e.target).val();
            let current_url = window.location.href;
            appended_mark = "?";
            if(current_url.includes("?")) {
                appended_mark = "&";
            }
            let url_category = getUrlParameter("category");
            if(! url_category)
            {
                current_url += appended_mark + "category=" + category;
            } else {
                let new_url = new URL(current_url);
                if(category != 0)
                {
                    new_url.searchParams.set("category", category);
                } else {
                    new_url.searchParams.delete("category");
                }
                current_url = new_url.href;
            }
            jobsManager.filters = jobsManager.getFilters(current_url);
            window.history.pushState("object or string", "Title", current_url);

            jobsManager.load();
        });

        $("select[name='location']").on("change", (e) => {
            jobsManager.reset();

            let location = $(e.target).val();
            let current_url = window.location.href;
            appended_mark = "?";
            if(current_url.includes("?")) {
                appended_mark = "&";
            }
            let url_location = getUrlParameter("location");
            let new_url = new URL(current_url);
            if(! url_location)
            {
                current_url += appended_mark + "location=" + location;
            } else {
                if(location != 0)
                {
                    new_url.searchParams.set("location", location);
                } else {
                    new_url.searchParams.delete("location");
                }
                current_url = new_url.href;
            }
            jobsManager.filters = jobsManager.getFilters(current_url);
            window.history.pushState("object or string", "Title", current_url);

            jobsManager.load();
        });

        $("input[name='job_nature']").on("change", (e) => {
            jobsManager.reset();

            let current_url = window.location.href;
            appended_mark = "?";
            if(current_url.includes("?")) {
                appended_mark = "&";
            }
            let new_url = new URL(current_url);
            
            let checked = $(e.target).attr("checked");

            let checked_job_nature = $(e.target).val();
            let url_job_natures = getUrlParameter("job_nature");
            let checked_job_natures;
            if(! url_job_natures)
            {
                if(!checked) checked_job_natures = [checked_job_nature];
                else checked_job_natures = [];
            } 
            else 
            {
                checked_job_natures = url_job_natures.split(",");
                if(!checked) 
                {
                    if(! checked_job_natures.includes(checked_job_nature)){
                        checked_job_natures.push(checked_job_nature);
                    }
                } else {
                    checked_job_natures = checked_job_natures.filter(function (job_nature) {
                        return job_nature !== checked_job_nature;
                    });
                }
            }
            if(checked) {
                $(e.target).removeAttr("checked");
            } else {
                $(e.target).attr("checked", "checked");
            }
            if(checked_job_natures.length)
                new_url.searchParams.set("job_nature", checked_job_natures.join(","));
            else 
                new_url.searchParams.delete("job_nature");

            current_url = new_url.href;
            jobsManager.filters = jobsManager.getFilters(current_url);
            window.history.pushState("object or string", "Title", current_url);

            jobsManager.load();
        });

        $("input[name='experience']").on("change", (e) => {
            jobsManager.reset();

            let current_url = window.location.href;
            appended_mark = "?";
            if(current_url.includes("?")) {
                appended_mark = "&";
            }
            let new_url = new URL(current_url);
            
            let checked = $(e.target).attr("checked");

            let checked_experience = $(e.target).val();
            let url_experiences = getUrlParameter("experience");
            let checked_experiences;
            if(! url_experiences)
            {
                if(!checked) checked_experiences = [checked_experience];
                else checked_experiences = [];
            } 
            else 
            {
                checked_experiences = url_experiences.split(",");
                if(!checked) 
                {
                    if(! checked_experiences.includes(checked_experience)){
                        checked_experiences.push(checked_experience);
                    }
                } else {
                    checked_experiences = checked_experiences.filter(function (experience) {
                        return experience !== checked_experience;
                    });
                }
            }
            if(checked) {
                $(e.target).removeAttr("checked");
            } else {
                $(e.target).attr("checked", "checked");
            }
            if(checked_experiences.length)
                new_url.searchParams.set("experience", checked_experiences.join(","));
            else 
                new_url.searchParams.delete("experience");

            current_url = new_url.href;
            jobsManager.filters = jobsManager.getFilters(current_url);
            window.history.pushState("object or string", "Title", current_url);

            jobsManager.load();
        });

        $(window).scroll(function () {
            let last_position = Math.round($(".jobs-container .single-job-items:last").position().top);
            if ($(window).scrollTop() >= last_position + 200) {
                jobsManager.loadMore();
            }
        });
    },

    reset:() => {
        jobsManager.offset = 0;
        jobsManager.lastJobsCount = 0;
        jobsManager.loadingMore = false;
    }
};

$( document ).ready(function() {
    jobsManager.init();
});