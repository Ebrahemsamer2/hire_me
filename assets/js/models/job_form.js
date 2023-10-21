let job_form = {
    countries: [],
    category_id: 0,
    location: '',
    slug: '',

    init: () => {
        if(typeof slug != undefined && slug){
            job_form.slug = slug;
        }
        if(typeof category_id != undefined && category_id){
            job_form.category_id = category_id;
        }
        if(typeof job_location != undefined && job_location){
            job_form.location = job_location;
        }

        job_form.loadCountries(() => {
            job_form.populateCountries();
        });
        category.loadAll((response) => {
            if(response.success && typeof response.categories != undefined && response.categories.length) {
                job_form.populateCategories(response.categories);
            }
        });
        job_form.applyActions();
    },

    loadCountries: (callback) => {
        $.ajax({
            url: "https://countriesnow.space/api/v0.1/countries",
            type: 'GET',
            success: (response) => {
                if(!response.error)
                {
                    job_form.countries = response.data;
                    callback();
                }
            }
        });
    },

    populateCountries: () => {
        let html = "<option value='0'>Country</option>";
        for(let index in job_form.countries)
        {
            let country = job_form.countries[index];
            html += "<option value='"+ country.country +"'>"+ country.country +"</option>";
        }
        $("select[name='country']").html(html);
        
        if(job_form.location) {
            let country = job_form.location ? job_form.location.split("-") : [];
            let city = '';
            if(country.length) {
                city = country[1].trim();
                country = country[0].trim();
                $("select[name='country']").val(country);
                job_form.populateCities(country, () => {
                    $("select[name='city']").val(city);
                });
            }
        }
    }, 

    populateCategories: (categories) => {
        let html = "<option value='0'>All Categories</option>";
        for(let index in categories)
        {
            let category = categories[index];
            html += "<option value='"+ category.id +"'>"+ category.name +"</option>";
        }
        $("select[name='category']").html(html);

        if(job_form.category_id) {
            $("select[name='category']").val(job_form.category_id);
        }
    }, 

    collectData: () => {
        let data = {};
        let title = $("input[name='title']").val().trim();
        let description = $("textarea[name='description']").val().trim();
        let country = $("select[name='country']").val().trim();
        let city = $("select[name='city']").val().trim();
        let required_knowledge = $("textarea[name='required_knowledge']").val().trim();
        let education_experience = $("textarea[name='education_experience']").val().trim();
        let vacancy_number = parseInt($("input[name='vacancy_number']").val().trim());
        let years_of_experience = $("select[name='years_of_experience']").val().trim();
        let job_nature = $("select[name='job_nature']").val().trim();
        let salary_from = parseInt($("input[name='salary_from']").val().trim());
        let salary_to = parseInt($("input[name='salary_to']").val().trim());
        let category_id = parseInt($("select[name='category']").val().trim());
        
        if(!title || !description || !country || !city || !required_knowledge || 
            !education_experience || !vacancy_number || !years_of_experience || !category_id)
        {
            message.show("All Fields are required.");
            return false;
        }
        if(vacancy_number < 1)
        {
            message.show("Invalid Vacancy Number.");
            return false;
        }
        if(salary_from > salary_to || salary_from < 1 || salary_to < 1)
        {
            message.show("Invalid Salary Range.");
            return false;
        }
        if(required_knowledge.length < 100 || education_experience.length < 100)
        {
            message.show("Required Knowledge and Education Should be greater than 100 characters.");
            return false;
        }

        data.title = title;
        data.description = description;
        data.country = country;
        data.city = city;
        data.required_knowledge = required_knowledge;
        data.education_experience = education_experience;
        data.vacancy_number = vacancy_number;
        data.years_of_experience = years_of_experience;
        data.category_id = category_id;
        data.job_nature = job_nature;
        data.salary_from = salary_from;
        data.salary_to = salary_to;
        return data;
    },

    save: () => {
        let data = job_form.collectData();
        data.action = 'save';
        if(typeof slug != undefined && slug) {
            data.slug = slug;
        }
        $.ajax({
            url: 'process/job.php',
            data: data,
            type: 'POST',
            success: (response) => {
                response = JSON.parse(response);
                if(response.success)
                {
                    message.show(response.message)
                    setTimeout(() => {
                        location.href = "new_job.php";
                    }, 1000);
                }
            }
        });
    },

    populateCities: (selected_country, callback) => {
        let country = job_form.countries.filter((country) => {
            return country.country == selected_country;
        })[0];

        let cities = country.cities;
        let html = "<option value='0'>City</option>";
        for(let index in cities)
        {
            let city = cities[index];
            html += "<option value='"+ city +"'>"+ city +"</option>";
        }
        $("select[name='city']").html(html);

        if(typeof callback != undefined && callback) {
            callback();
        }
    },

    applyActions: () => {
        $("select[name='country']").on("change", (e) => {
            let country_selected = $(e.target).val();
            job_form.populateCities(country_selected);
        });

        $("input[name='save_job']").on("click", (e) => {
            e.preventDefault();
            job_form.save();
        });
    }
};


$( document ).ready(function() {
    job_form.init();
});