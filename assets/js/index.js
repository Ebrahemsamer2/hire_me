let home = {
    categories: [],
    init: () => {
        category.loadAll((response) => {
            home.categories = response.categories;
            home.populateCategories();
        })
    },
    populateCategories: () => {
        let html = '';
        home.categories.forEach((category) => {
            html += `
            <div id='category-${category.id}' class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                <div class="single-services text-center mb-30">
                    <div class="services-cap">
                        <h5><a href="job_listing.php?category=${category.slug}">${category.name}</a></h5>
                        <span>(0)</span>
                    </div>
                </div>
            </div>
            `;
        });
        $(".home-categories").html(html);
    },
}



$( document ).ready(function() {
    home.init();
});