let category = 
{
    loadAll: (callback) => {
        let data = {'action': 'loadAll'};
        $.ajax({
            url: 'process/category.php',
            data: data,
            type: 'POST',
            success: (response) => { 
                response = JSON.parse(response);
                if(response.success)
                {
                    callback(response)
                }
            }
        });
    }
};